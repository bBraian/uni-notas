<?php
namespace Unisinos\Notas\Models;

// use Sgs\Campanhas\Models\Util;

class UniNotas {

    var $connPdo;

    function __construct() {
        $this->connPdo = new \PDO(DBDRIVE . ':host=' . DBHOST . ';port=3306;dbname=' . DBNAME . ';charset=' . DBCHARSET, DBUSER, DBPASS);
    }

    public function insertCadeira($cadeira, $cor) {
        $sql="INSERT INTO `unisinos_cadeiras` 
        (`nome_cadeira`,`status`,`cor`,`data_criacao`) 
        VALUES ('".$cadeira."','2','".$cor."',NOW());";
        $stmt = $this->connPdo->prepare($sql);
        $stmt->execute();
    }

    public function getCadeira() {
        $sql="SELECT n.*, 
        (SELECT SUM(a.nota) FROM unisinos_notas a WHERE a.grau = 'A' AND n.id = a.unisinos_notas_id) AS nota_ga,
        (SELECT SUM(b.nota) FROM unisinos_notas b WHERE b.grau = 'B' AND n.id = b.unisinos_notas_id) AS nota_gb
        FROM unisinos_cadeiras n
        ORDER BY n.`status` DESC";
        $stmt = $this->connPdo->prepare($sql);
        $stmt->execute();
        $qtd = $stmt->rowCount();
        if ($qtd > 0) {
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $retorno = [
                "qtd" => $qtd,
                "cadeira" => $result
            ];
            return $retorno;
        } else {
            return false;
        }
    }

    public function calculaMedia($notaGa, $notaGb) {
        $media = (($notaGa * 0.33) + ($notaGb * 0.67));
        return $media;
    }

    public function calculaNotaFalta($notaGa) {
        $nota_falta = ((6-($notaGa * 0.33))/0.67);
        return $nota_falta;
    }

    public function getIdNomeCadeiras() {
        $sql="SELECT id, nome_cadeira
        FROM unisinos_cadeiras
        WHERE STATUS = 2";
        $stmt = $this->connPdo->prepare($sql);
        $stmt->execute();
        $qtd = $stmt->rowCount();
        if ($qtd > 0) {
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            $retorno = [
                "qtd" => $qtd,
                "cadeira" => $result
            ];
            return $retorno;
        } else {
            return false;
        }
    }

    public function validateChair($cod_cadeira) {
        $sql="SELECT c.id
        FROM unisinos_cadeiras c
        WHERE c.id = '".$cod_cadeira."' AND c.status = '2'";
        $stmt = $this->connPdo->prepare($sql);
        $stmt->execute();
        $qtd = $stmt->rowCount();
        if ($qtd > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function salvarNota($grau, $descricao, $nota, $nota_max, $cadeira) {
        $result = [
            "erro" => "S",
            "mensagem" => "Algo de errado!"
        ];
        if($this->validateChair($cadeira)) {
            if($this->validateGrau($grau)) {
                $sql="INSERT INTO `unisinos_notas` 
                (`unisinos_notas_id`, `grau`, `descricao`, `nota`, `nota_max`) 
                VALUES ('".$cadeira."', '".$grau."', '".$descricao."', '".$nota."', '".$nota_max."')";
                $stmt = $this->connPdo->prepare($sql);
                $stmt->execute();
                if($grau == "B") {
                    $sql="UPDATE unisinos_cadeiras c
                    SET c.status = 1
                    WHERE id = '".$cadeira."'";
                    $stmt = $this->connPdo->prepare($sql);
                    $stmt->execute();
                }
                $result = [
                    "erro" => "N",
                    "mensagem" => "Nota inserida com sucesso!"
                ];
            } else {
                $result = [
                    "erro" => "S",
                    "mensagem" => "Grau cagado"
                ];
            }
        } else {
            $result = [
                "erro" => "S",
                "mensagem" => "validate chiar"
            ];
        }

        return $result;
    }

    private function validateGrau($grau) {
        switch ($grau) {
            case "A":
                return true;
                break;
            case "B":
                return true;
                break;
            case "C":
                return true;
                break;
            default:
                return false;
        }
    }

}