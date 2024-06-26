<?php
declare(strict_types=1);
namespace App\Infrastructure\Shared\Service;

use App\Domain\Shared\Enum\EmailPriority;
use App\Domain\Shared\Exception\MailSendException;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Represents a service for sending emails with priority.
 * This service allows sending emails with different priority levels.
 *
 * Methods:
 * - __construct(MailerInterface $mailer, Environment $twig): Constructor to initialize the email service with mailer and Twig environment.
 *   - Parameters:
 *     - MailerInterface $mailer: The mailer interface for sending emails.
 *     - Environment $twig: The Twig environment for rendering email templates.
 *
 * - sendEmail(string $recipient, string $subject, string $templatePath, EmailPriority $priority, array $context = []): void: Method to send an email with specified priority level.
 *   - Parameters:
 *     - string $recipient: The recipient's email address.
 *     - string $subject: The subject of email.
 *     - string $templatePath: The path to email template.
 *     - EmailPriority $priority: The priority level of email.
 *     - array $context: The context data to be passed to email template.
 *   - Throws:
 *     - LoaderError: If an error occurs while loading the email template.
 *     - RuntimeError: If an error occurs during email rendering.
 *     - SyntaxError: If there is syntax error in the email template.
 *     - MailSendException: If an error occurs while sending the email.
 *
 * - sendEmailToMultipleRecipients(array $recipients, string $subject, string $templatePath, EmailPriority $priority, array $context = []): void: Method to send an email multiple recipients with specified priority level.
 *   - Parameters:
 *     - array $recipients: An array of recipient email addresses.
 *     - string $subject: The subject of email.
 *     - string $templatePath: The path to email template.
 *     - EmailPriority $priority: The priority level of email.
 *     - array $context: The context data to be passed to email template.
 *   - Throws:
 *     - LoaderError: If an error occurs while loading the email template.
 *     - RuntimeError: If an error occurs during email rendering.
 *     - SyntaxError: If there is syntax error in the email template.
 *     - MailSendException: If an error occurs while sending the email.
 */
readonly class EmailService
{
    private string $mailerFromAddress;
    private string $mailerName;
    private array $envVars;

    public function __construct(
        private MailerInterface $mailer,
        private Environment $twig
    ) {
        $this->mailerFromAddress = $_ENV['MAILER_FROM_ADDRESS'];
        $this->mailerName = $_ENV['MAILER_NAME'];

        $this->envVars = [
            'company_name' => $_ENV['COMPANY_NAME'],
            'help_link' => $_ENV['HELP_LINK'],
            'terms_of_service' => $_ENV['TERMS_OF_SERVICE'],
            'privacy_policy' => $_ENV['PRIVACY_POLICY']
        ];
    }

    /**
     * @param string $recipient
     * @param string $subject
     * @param string $templatePath
     * @param EmailPriority $priority
     * @param array $context
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws MailSendException
     */
    public function sendEmail(
        string $recipient,
        string $subject,
        string $templatePath,
        EmailPriority $priority,
        array $context = []
    ): void {
        $templateContent = $this->twig->render($templatePath, array_merge($context, $this->envVars));

        $email = (new Email())
            ->from(new Address($this->mailerFromAddress, $this->mailerName))
            ->to($recipient)
            ->subject($subject)
            ->html($templateContent);

        $this->setEmailPriority($email, $priority);
        $this->attachFilesToEmail($email, $context['attachments'] ?? []);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface) {
            throw new MailSendException();
        }
    }

    /**
     * @param array $recipients
     * @param string $subject
     * @param string $templatePath
     * @param EmailPriority $priority
     * @param array $context
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws MailSendException
     */
    public function sendEmailToMultipleRecipients(
        array $recipients,
        string $subject,
        string $templatePath,
        EmailPriority $priority,
        array $context = []
    ): void {
        $templateContent = $this->twig->render($templatePath, array_merge($context, $this->envVars));

        $email = (new Email())
            ->from(new Address($this->mailerFromAddress, $this->mailerName))
            ->subject($subject)
            ->html($templateContent);

        $this->multipleRecipients($email, $recipients);
        $this->setEmailPriority($email, $priority);
        $this->attachFilesToEmail($email, $context['attachments'] ?? []);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface) {
            throw new MailSendException();
        }
    }

    /**
     * Set priority of the email.
     *
     * @param Email $email The email message to set the priority for.
     * @param EmailPriority $priority The priority level of the email.
     */
    private function setEmailPriority(Email $email, EmailPriority $priority): void
    {
        $priorityMap = [
            EmailPriority::LOW()->getValue() => Email::PRIORITY_LOW,
            EmailPriority::NORMAL()->getValue() => Email::PRIORITY_NORMAL,
            EmailPriority::HIGH()->getValue() => Email::PRIORITY_HIGH,
        ];
        $email->priority($priorityMap[$priority->getValue()] ?? Email::PRIORITY_NORMAL);
    }

    /**
     * Attach files to the email.
     *
     * @param Email $email The email message to attach files to.
     * @param array $attachments An array of file paths to be attached to the email.
     */
    private function attachFilesToEmail(Email $email, array $attachments): void
    {
        foreach ($attachments as $attachment) {
            $email->attachFromPath($attachment['attach'], $attachment['rename'] ?? null);
        }
    }

    /**
     * Adds recipients and optionally carbon copy (cc) addresses to the email.
     *
     * @param Email $email The email message object to which recipients are being added.
     * @param array $recipients An array of recipient addresses.
     * It can contain email address strings or associative arrays with 'email' and 'name' keys.
     * @param array $cc An array of carbon copy (cc) addresses.
     * It can contain email address strings or associative arrays with 'email' and 'name' keys.
     * @param array $bcc An array of blind carbon copy (bcc) addresses.
     * It can contain email address strings or associative arrays with 'email' and 'name' keys.
     * @return void
     */
    private function multipleRecipients(Email $email, array $recipients, array $cc = [], array $bcc = []): void
    {
        $prepareAddresses = static function (array $addresses): array {
            $uniqueAddresses = [];
            foreach ($addresses as $address) {
                $emailStr = is_array($address) ? $address['email'] : $address;
                $name = is_array($address) ? ($address['name'] ?? '') : '';
                if (!isset($uniqueAddresses[$emailStr])) {
                    $uniqueAddresses[$emailStr] = $name;
                }
            }
            $result = [];
            foreach ($uniqueAddresses as $emailStr => $name) {
                $result[] = new Address($emailStr, $name);
            }
            return $result;
        };
        $email->to(...$prepareAddresses($recipients));

        if (!empty($cc)) {
            $email->cc(...$prepareAddresses($cc));
        }

        if (!empty($bcc)) {
            $email->bcc(...$prepareAddresses($bcc));
        }
    }
}
