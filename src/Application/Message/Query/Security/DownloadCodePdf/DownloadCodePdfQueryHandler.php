<?php
declare(strict_types=1);
namespace App\Application\Message\Query\Security\DownloadCodePdf;

use App\Domain\Security\Exception\InvalidateCodeException;
use App\Domain\Security\Repository\FindNonInvalidatedByUserUuidInterface;
use App\Infrastructure\Shared\Service\PdfService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * This class is a query handler for processing the `DownloadCodePdfQuery`.
 * It implements the `MessageHandlerInterface` and uses repository to find non-invalidated security codes by user UUID.
 *
 * Constructor Parameters:
 * - `FindNonInvalidatedByUserUuidInterface $nonInvalidatedCodeFinder`: The repository interface used to find non-invalidated security codes.
 * - `PdfService $pdfService`: The service used to generate PDFs.
 *
 * Method:
 * - `__invoke(DownloadCodePdfQuery $query)`: Processes the `DownloadCodePdfQuery` to generate a PDF containing security codes.
 *   It retrieves non-invalidated security codes from the repository using the UUID and purpose from the query.
 *
 * Exceptions:
 * - `InvalidateCodeException`: Thrown if no valid security codes are found for the provided UUID and purpose.
 * - `RuntimeError`: Thrown if there is an error during template rendering.
 * - `SyntaxError`: Thrown if there is a syntax error in the template.
 * - `LoaderError`: Thrown if the template cannot be loaded.
 */
readonly class DownloadCodePdfQueryHandler implements MessageHandlerInterface
{
    public function __construct(
        private FindNonInvalidatedByUserUuidInterface $nonInvalidatedCodeFinder,
        private PdfService $pdfService
    ) { }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function __invoke(DownloadCodePdfQuery $query): void
    {
        $entity = $this->nonInvalidatedCodeFinder->findNonInvalidatedByUserUuid($query->getUuid(), $query->getPurpose());
        if ($entity === null) {
            throw new InvalidateCodeException();
        }

        $this->generatePDF($entity->getSecurityCodes()->toArray());
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    private function generatePDF(array $codes): void
    {
        $statusCodes = array_map(static fn($securityCode) => [
            'code' => $securityCode->getCode(),
            'status' => $securityCode->getStatus(),
        ], $codes);

        $array = [
            'company_name' => $_ENV['COMPANY_NAME'],
            'codes' => $statusCodes
        ];

        $this->pdfService->generatePdfResponse('Pdf/security_code_template.html.twig', $array, 'authorization_codes.pdf');
    }
}
