<?php
require_once '../../../vendor/autoload.php';
use Unisinos\Notas\Models\UniNotas;

$tipo=isset($_POST['tipo'])?$_POST['tipo']:0;
    
switch ($tipo) {
    case "novo":
        $cadeira = isset($_POST['cadeira'])?$_POST['cadeira']:0;
        $cor = isset($_POST['cor'])?$_POST['cor']:0;
        $uniNotas = new UniNotas();
        $uniNotas->insertCadeira($cadeira, $cor);
        $return = [
            "erro" => "N"
        ];
        break;
    case "validate_chair":
        $cod_cadeira_selecionada = isset($_POST['cadeira_selecionada'])?$_POST['cadeira_selecionada']:0;
        $uniNotas = new UniNotas();
        $validou = $uniNotas->validateChair($cod_cadeira_selecionada);
        if($validou) {
            $return = [
                "erro" => "N"
            ];
        } else {
            $return = [
                "erro" => "S"
            ];
        }
        break;
    case "salvar_nota":
        $grau = $_POST['grau'];
        $descricao = $_POST['descricao'];
        $nota = $_POST['nota'];
        $nota_max = $_POST['nota_max'];
        $cadeira = $_POST['cadeira'];
        $uniNotas = new UniNotas();
        $result = $uniNotas->salvarNota($grau, $descricao, $nota, $nota_max, $cadeira);
        if($result["erro"] == "N") {
            $return = [
                "erro" => "N",
                "mensagem" => $result["mensagem"]
            ];
        } else {
            $return = [
                "erro" => "S",
                "mensagem" => $result["mensagem"]
            ];
        }
       
        break;
    default:
        $return = [
            "erro" => "S",
            "mensagem" => "Erro ao salvar ou atualizar dados!"
        ];
}


$json = json_encode($return);
echo $json;

