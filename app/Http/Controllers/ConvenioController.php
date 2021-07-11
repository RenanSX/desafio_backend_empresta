<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConvenioController extends Controller
{
    /**
     *  Método que retorna todas os convenios
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            $response = [];
            // Pega o arquivo .json de convenios e transforma em array
            $json = Storage::disk('local')->get('database/convenios.json');
            $json = json_decode($json, true);
            // Caso vazio retorna 204 (Dependendo de quem chama, seja necessário alterar para 404)
            if (empty($json)) {
                return response()->json('', 204);
            }
            // Percorre o json criando um novo formato
            // a partir da chave e valor
            foreach ($json as $key => $value) {
                $response[$key][$value['chave']] = $value['valor'];
            }
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed',
            ], 500);
        }
    }
}
