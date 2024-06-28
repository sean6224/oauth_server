<?php
declare(strict_types=1);
namespace App\Infrastructure\Security\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Application\Message\Query\Security\DownloadCodePdf\DownloadCodePdfQuery;
use App\Domain\Security\ValueObject\Purpose;
use App\Infrastructure\Shared\Bus\Query\QueryBus;
use Throwable;

/**
 * This class is a processor for downloading security code PDFs in an API Platform context.
 * It implements the `ProcessorInterface` and uses `QueryBus` to handle the `DownloadCodePdfQuery`.
 *
 * Constructor Parameters:
 * - `QueryBus $queryBus`: The query bus used to dispatch the `DownloadCodePdfQuery`.
 *
 * Method:
 * - `process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])`: Processes the input data to download a security code PDF.
 *   It creates a `DownloadCodePdfQuery` with the necessary parameters and dispatches it through the query bus.
 *
 * Parameters for `process`:
 * - `mixed $data`: The data required to download the security code PDF, typically from an API request.
 * - `Operation $operation`: Represents the operation context.
 * - `array $uriVariables`: Contains the UUID of the user for whom the PDF is downloaded.
 * - `array $context`: Additional context for the processing operation.
 *
 * Exceptions:
 * - `Throwable`: Can be thrown if an error occurs during query handling.
 */
readonly class DownloadCodeProcessor implements ProcessorInterface
{
    public function __construct(
        private QueryBus $queryBus,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $pdf = new DownloadCodePdfQuery($uriVariables['uuid'], Purpose::fromString($data->purpose));
        $this->queryBus->handle($pdf);
    }
}
