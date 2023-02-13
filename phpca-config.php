<?php

declare(strict_types=1);

use Chetkov\PHPCleanArchitecture\Infrastructure\Event\EventManager;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Analysis\AnalysisEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Analysis\ComponentAnalysisEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Analysis\FileAnalyzedEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Report\ComponentReportRenderingEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Report\ReportBuildingEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Report\ReportRenderingEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Event\Listener\Report\UnitOfCodeReportRenderedEventListener;
use Chetkov\PHPCleanArchitecture\Infrastructure\Render\TwigToTemplateRendererInterfaceAdapter;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\CodeParsingDependenciesFinder;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ClassesCalledStaticallyParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ClassesCreatedThroughNewParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ClassesFromInstanceofConstructionParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\MethodAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ParamAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\PropertyAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ReturnAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\ThrowsAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CodeParsing\Strategy\VarAnnotationsParsingStrategy;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\CompositeDependenciesFinder;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\DependenciesFinderInterface;
use Chetkov\PHPCleanArchitecture\Service\Analysis\DependenciesFinder\ReflectionDependenciesFinder;
use Chetkov\PHPCleanArchitecture\Service\EventManagerInterface;
use Chetkov\PHPCleanArchitecture\Service\Report\DefaultReport\ReportRenderingService;
use Chetkov\PHPCleanArchitecture\Service\Report\ReportRenderingServiceInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [
    // Директория в которую будут складываться файлы отчета
    'reports_dir' => __DIR__ . '/runtime/phpca-reports',

    // Учет vendor пакетов (каждый подключенный пакет, за исключением перечисленных в excluded, будет представлен компонентом)
    'vendor_based_components' => [
        'enabled' => true,
        'vendor_path' => __DIR__ . '/vendor',
    ],

    // Общие для всех компонентов ограничения
    'restrictions' => [
        // Включение/отключение обнаружения нарушений принципа ацикличности зависимостей.
        'check_acyclic_dependencies_principle' => true,

        // Включение/отключение обнаружения нарушений принципа устойчивых зависимостей.
        'check_stable_dependencies_principle' => true,

        // Максимально допустимое расстояние до главной диагонали.
        // Элемент может отсутствовать или быть null, в таком случае ограничения не будут применены.
        'max_allowable_distance' => 0.1,
    ],

    // Описание компонентов и их ограничений
    'components' => [
        [
            'name' => 'Inform',
            'roots' => [
                [
                    'path' => 'src',
                    'namespace' => 'Viktorprogger\\YiisoftInform',
                ],
            ],
        ],
        [
            'name' => 'GitHub',
            'roots' => [
                [
                    'path' => 'src/SubDomain/GitHub',
                    'namespace' => 'Viktorprogger\\YiisoftInform\\SubDomain\\GitHub',
                ],
            ],
        ],
        [
            'name' => 'Telegram',
            'roots' => [
                [
                    'path' => 'src/SubDomain/Telegram',
                    'namespace' => 'Viktorprogger\\YiisoftInform\\SubDomain\\Telegram',
                ],
            ],
        ],
    ],

    // Исключения
    'exclusions' => [
        'allowed_state' => [
            'enabled' => false,
            'storage' => __DIR__ . '/phpca-allowed-state.php',
        ],
    ],

    'factories' => [
        //Фабрика, собирающая DependenciesFinder
        'dependencies_finder' => static function (): DependenciesFinderInterface {
            return new CompositeDependenciesFinder(...[
                                                          new ReflectionDependenciesFinder(),
                                                          new CodeParsingDependenciesFinder(...[
                                                                                                   new ClassesCreatedThroughNewParsingStrategy(
                                                                                                   ),
                                                                                                   new ClassesCalledStaticallyParsingStrategy(
                                                                                                   ),
                                                                                                   new ClassesFromInstanceofConstructionParsingStrategy(
                                                                                                   ),
                                                                                                   new PropertyAnnotationsParsingStrategy(
                                                                                                   ),
                                                                                                   new MethodAnnotationsParsingStrategy(
                                                                                                   ),
                                                                                                   new ParamAnnotationsParsingStrategy(
                                                                                                   ),
                                                                                                   new ReturnAnnotationsParsingStrategy(
                                                                                                   ),
                                                                                                   new ThrowsAnnotationsParsingStrategy(
                                                                                                   ),
                                                                                                   new VarAnnotationsParsingStrategy(
                                                                                                   ),
                                                                                               ]),
                                                      ]);
        },
        //Фабрика, собирающая сервис рендеринга отчетов
        'report_rendering_service' => static function (EventManagerInterface $eventManager
        ): ReportRenderingServiceInterface {
            $templatesLoader = new FilesystemLoader(ReportRenderingService::templatesPath());
            $twigRenderer = new Environment($templatesLoader);
            $twigAdapter = new TwigToTemplateRendererInterfaceAdapter($twigRenderer);

            return new ReportRenderingService($eventManager, $twigAdapter);
        },
        //Фабрика, собирающая и настраивающая EventManager
        'event_manager' => static function (): EventManagerInterface {
            return new EventManager([
                                        new ReportBuildingEventListener(),
                                        new AnalysisEventListener(),
                                        new ComponentAnalysisEventListener(),
                                        new FileAnalyzedEventListener(),
                                        new ReportBuildingEventListener(),
                                        new ReportRenderingEventListener(),
                                        new ComponentReportRenderingEventListener(),
                                        new UnitOfCodeReportRenderedEventListener(),
                                    ]);
        },
    ],
];
