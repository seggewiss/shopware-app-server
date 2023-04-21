<?php declare(strict_types=1);

use PhpCsFixer\Fixer\FunctionNotation\NativeFunctionInvocationFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::STRICT);

    $services = $containerConfigurator->services();

    $services
        ->set(NativeFunctionInvocationFixer::class)
        ->call('configure', [[
            'include' => [NativeFunctionInvocationFixer::SET_ALL],
            'scope' => 'namespaced',
        ]])
        ->set(LineLengthFixer::class)
        ->call('configure', [[
            'max_line_length' => 120,
            'break_long_lines' => true,
            'inline_short_lines' => false,
        ]])
        ->set(NoUnusedImportsFixer::class)
        ->set(SingleLineAfterImportsFixer::class);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/migrations',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);
};
