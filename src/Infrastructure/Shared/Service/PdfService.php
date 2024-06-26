<?php
declare(strict_types=1);
namespace App\Infrastructure\Shared\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Represents a service for generating PDF documents.
 * This service allows generating PDF documents from Twig templates.
 *
 * Methods:
 * - __construct (Environment $twig): Constructor to initialize the PDF service with Twig environment.
 *   - Parameters:
 *     - Environment $twig: The Twig environment for rendering PDF templates.
 *
 * - savePdfToFile(string $templatePath, array $context, string $filePath): void: Method to save PDF to a file.
 *   - Parameters:
 *     - string $templatePath: The path to PDF template.
 *     - array $context: The context data to be passed to PDF template.
 *     - string $filePath: The path to save the generated PDF file.
 *   - Throws:
 *     - LoaderError: If an error occurs while loading the PDF template.
 *     - RuntimeError: If an error occurs during PDF rendering.
 *     - SyntaxError: If there is syntax error in the PDF template.
 *
 * - generatePdfResponse(string $templatePath, array $context, string $fileName = 'document.pdf'): Response: Method to generate PDF as HTTP response.
 *   - Parameters:
 *     - string $templatePath: The path to PDF template.
 *     - array $context: The context data to be passed to PDF template.
 *     - string $fileName: The name of the generated PDF file (default is 'document.pdf').
 *   - Returns:
 *     - Response: The HTTP response containing the generated PDF.
 *   - Throws:
 *     - LoaderError: If an error occurs while loading the PDF template.
 *     - RuntimeError: If an error occurs during PDF rendering.
 *     - SyntaxError: If there is syntax error in the PDF template.
 */
class PdfService
{
    private Environment $twig;
    private Dompdf $dompdf;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $this->dompdf = new Dompdf($options);
        $this->dompdf->setPaper('A4');
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function savePdfToFile(string $templatePath, array $context, string $filePath): void
    {
        $html = $this->twig->render($templatePath, $context);
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();

        file_put_contents($filePath, $this->dompdf->output());
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function generatePdfResponse(string $templatePath, array $context, string $fileName = 'document.pdf'): Response
    {
        $html = $this->twig->render($templatePath, $context);
        $this->dompdf->loadHtml($html);
        $this->dompdf->render();

        return $this->createResponse($fileName);
    }

    private function createResponse(string $fileName): Response
    {
        return new Response(
            $this->dompdf->stream($fileName, ["Attachment" => true]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }
}
