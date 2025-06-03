<?php
namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class GerarRelatorio
{
    /** @var string $path */
    private static $path = "reports";

    /**
     * --> Seguir sequência dos ids
     * --> Seguir modelo abaixo
     *
     * @var array
     */
    public static $relatorios = [
        [
            'id'         => 1,
            'nome'       => 'Exemplo PDF',
            'template'   => 'exemplo-pdf',
            'tipo'       => [
                'pdf',
            ],
            'perfil'     => [
                'Administrador',
            ],
            'menu'       => false,
        ],
        [
            'id'         => 2,
            'nome'       => 'Cobranca',
            'template'   => 'cobranca',
            'tipo'       => [
                'pdf',
                'view'
            ],
            'perfil'     => [
                'Administrador',
                'Difusor'
            ],
            'menu'       => false,
        ],
    ];

    // --> Filtros

    /**
     * Retorna a informação do relatório de acordo com o ID
     *
     * @param integer $id
     * @return array
     */
    public static function filtrarRelatorioPorId(int $id): array
    {
        return Arr::first(Arr::where(self::$relatorios, function ($relatorio) use ($id) {
            return $relatorio['id'] == $id;
        }));
    }

    /**
     * Retorna a informação dos relatórios baseado no perfil
     *
     * @param string|integer|array $perfil
     * @return GerarRelatorio
     */
    public static function filtrarRelatorioPorPerfil($perfil = null): GerarRelatorio
    {
        self::$relatorios = Arr::where(self::$relatorios, function ($relatorio) use ($perfil) {
            return in_array($perfil, $relatorio['perfil']);
        });

        return new static();
    }

    /**
     * Retorna os relatórios, e também os que são filtrados
     *
     * @return array
     */
    public static function get(): array
    {
        return self::$relatorios;
    }

    // --> Download e view

    /**
     * Renderiza os dados de acordo com o tipo de arquivo
     *
     * @param integer $relatorioId
     * @param string $type --> view|pdf|excel
     * @param array $data
     * @return mixed
     */
    public static function renderizar(int $relatorioId, string $type, array $data = [], string $title = '')
    {
        $relatorio    = self::filtrarRelatorioPorId($relatorioId);
        $pathToRender = self::$path . ".{$type}.{$relatorio['template']}";
        $fileName     = Str::slug((!empty($title) ? $title : $relatorio['nome']));

        if (!in_array($type, $relatorio['tipo'])) {
            return redirect()->back()->with('msgErro', "Este tipo de documento não está disponível para este relatório.");
        }

        if ($type === "view") {
            return view($pathToRender, $data);
        }

        if ($type === "pdf") {
            $view = view($pathToRender, $data);
            $tipo  = 'portrait';
            if(in_array($relatorioId, [101, 2]))
                $tipo  = 'landscape';

            return pdf($view, 'A4', $tipo, true)->download("{$fileName}.pdf");
        }

        if ($type === "excel" || $type === "csv") {
            return excel($pathToRender, $fileName, $data);
        }

    }

    /**
     * Retorna a informação dos relatórios para o menu
     *
     * @param string|integer|array $menu
     * @return GerarRelatorio
     */
    public static function getRelatorioMenu()
    {
        return array_filter(self::$relatorios, function ($relatorio) {
            return $relatorio['menu'];
        });
    }
}
