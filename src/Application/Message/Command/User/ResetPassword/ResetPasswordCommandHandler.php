<?php
declare(strict_types=1);
namespace App\Application\Message\Command\User\ResetPassword;

use App\Application\Service\SecurityCodeService;
use App\Domain\Shared\Enum\EmailPriority;
use App\Domain\User\Repository\GetUserByEmailInterface;
use App\Domain\User\ValueObject\Email;
use App\Infrastructure\Shared\Bus\Command\CommandHandlerInterface;
use App\Infrastructure\Shared\Service\EmailService;
use DateTime;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final readonly class ResetPasswordCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private GetUserByEmailInterface $userUuidRepository,
        private EmailService $emailService,
        private TranslatorInterface $translator,
        private SecurityCodeService $codeService
    ) {
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(ResetPasswordCommand $command): void
    {
        if ($command->getEmail() !== null)
        {
            $this->sendMail($command->getEmail());
        }

    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    private function sendMail(string $mail): void
    {
        $user = $this->userUuidRepository->getUserByEmail(
            Email::fromString($mail)
        );

        $template = 'emails/reset_password_email_template.html.twig';

        $context = [
            'expiration_date' => new DateTime('+2 days'),
            'username' => $user->getUsername()->value(),
            'url_reset' => $_ENV['URL_'].'id',
        ];

        $this->emailService->sendEmail(
            $mail,
            $this->translator->trans('subject', [], 'restart_password'),
            $template,
            EmailPriority::HIGH(),
            $context
        );
    }
}
