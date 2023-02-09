<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class ItemsRouterComponent extends CBitrixComponent
{
    /**
     * Шаблоны роутов
     * @var array
     */
    protected array $defaultUrlTemplates404 = [];

    /**
     * Переменные шаблонов роутов
     * @var array
     */
    protected array $componentVariables = [];

    /**
     * Страница шаблона
     * @var string
     */
    protected string $page = '';

    protected function setSefDefaultParams()
    {
        $this->defaultUrlTemplates404 = [
            'index' => 'index.php',
            'detail' => 'detail/#ELEMENT_ID#/'
        ];
        $this->componentVariables = ['ELEMENT_ID'];
    }

    public function executeComponent()
    {
        try {

            $this->setSefDefaultParams();

            $urlTemplates = [];
            if ($this->arParams['SEF_MODE'] == 'Y') {

                $variables = [];

                $urlTemplates = \CComponentEngine::makeComponentUrlTemplates(
                    $this->defaultUrlTemplates404,
                    $this->arParams['SEF_URL_TEMPLATES']
                );

                $variableAliases = \CComponentEngine::MakeComponentVariableAliases(
                    $this->defaultUrlTemplates404,
                    $this->arParams['VARIABLE_ALIASES']
                );

                $engine = new CComponentEngine($this);

                if (CModule::IncludeModule('iblock')) {
                    $engine->addGreedyPart("#SECTION_CODE_PATH#");
                    $engine->setResolveCallback(["CIBlockFindTools", "resolveComponentEngine"]);
                }

                $this->page = $engine->guessComponentPath(
                    $this->arParams['SEF_FOLDER'],
                    $urlTemplates,
                    $variables
                );

                if (strlen($this->page) <= 0) {
                    $this->page = 'index';
                }

                \CComponentEngine::InitComponentVariables(
                    $this->page,
                    $this->componentVariables, $variableAliases,
                    $variables
                );
            } else {
                $this->page = 'index';
            }
            $this->arResult[] = [
                'FOLDER' => $this->arParams['SEF_FOLDER'],
                'URL_TEMPLATES' => $urlTemplates,
                'VARIABLES' => $variables,
                'ALIASES' => $variableAliases
            ];

            $this->includeComponentTemplate($this->page);
        } catch (\Exception $e) {
            ShowError($e->getMessage());
        }
    }
}
