<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CreditoController extends Controller
{
    /**
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function creditAvailable(Request $request) {
        try {
            $response = [];
            // Valida os campos passados no corpo da requisição, são eles:
            // valor_emprestimo, instituicoes, convenios e parcela, sendo valor_emprestimo
            // o único obrigatório
            $request->validate([
                'valor_emprestimo' => 'required|numeric|min:1|max: 9999.99|regex:/^\d+(\.\d{1,2})?$/',
                'instituicoes' => 'array|min:1',
                'convenios' => 'array|min:1',
                'parcelas' => 'integer|mod12',
            ]);
            // Pega o arquivo .json de taxas instituicoes e transforma em array
            $json = Storage::disk('local')->get('database/taxas_instituicoes.json');
            $json = json_decode($json, true);
            if (empty($json)) {
                return response()->json('', 204);
            }
            // Caso os campos instituicoes, convenios ou parcelas estejam faltanto
            // é impossivel calcular o crédito
            if (empty($request->instituicoes) || empty($request->convenios) || !isset($request->parcelas)) {
                return response()->json(['message' => "Unable to calculate credit!"], 404);
            }
            // ====================================================
            /// Cálculo de crédito disponivel
            // ====================================================
            // O cálculo é feito da seguinte maneira, primeiro percorre o arary de instituicoes do payload informado pelo usuario
            // depois percorre o json (base de dados) das taxas das instituiçoes
            // Confere se as instituicoes batem, depois verifica se os convenios existem para essa instituicao e se
            // o número de parcelas batem, se sim calcula o valor da parcela pelo calculo: valor_emprestimo * coeficiente
            // e retorna o array no seguinte formato:
            // {
            //    "Instituicao": {
            //        "Convencio": {
            //            "parcelas": numero de parcelas informado,
            //            "valor_parcela": calculo: valor_emprestimo * coeficiente,
            //            "taxa": taxa
            //        }
            //    }
            // }
            foreach ($request->instituicoes as $inst) {
                foreach ($json as $tax_inst) {
                    if ($inst == $tax_inst['instituicao']) {
                        if (in_array($tax_inst['convenio'], $request->convenios) && $request->parcelas == $tax_inst["parcelas"]) {
                            $response[$inst][$tax_inst["convenio"]] = [
                                "parcelas" => $request->parcelas,
                                "valor_parcela" => round($request->valor_emprestimo * $tax_inst["coeficiente"], 2),
                                "taxa" => $tax_inst["taxaJuros"]
                            ];
                        }
                    }
                }
            }
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed',
            ], 500);
        }
    }
}
