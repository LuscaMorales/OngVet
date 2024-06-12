<?php

    require_once("config.php");

    class DBcontext{
        private $host;
        private $porta;
        private $dbname;
        private $usuario;
        private $senha;

        private $conexao;

        public function __contruct(){
            $this->host = "localhost";
            $this->porta = 3306;
            $this->dbname = "estaciovet";
            $this->usuario = "root";
            $this->senha = "";
        }

        public function conectar() {
            $this->conexao = new mysqli("localhost", "root", "", "estaciovet");
            if($this->conexao->connect_error){
                die("Conexão falhou: " . $this->conexao->connect_error);
            }
        
        }

        public function desconectar() {
            $this->conexao->close();
        }

        public function executar_query($query){
            $resultado = $this->conexao->query($query);

            if(!$resultado){
                $error = array('error' => $this->conexao->error);
                return json_encode($error);
            }

            if($resultado->num_rows > 0) {
                $linhas = array();
                while ($linha = $resultado->fetch_assoc()) {
                    $linhas[] = $linha;
                }

                return json_encode($linhas);
            }
            return json_encode($resultado);
        }

        public function adicionar($nome, $especie, $raca, $dataChegada, $dataNascimento){
            $query = "INSERT INTO animais (id, nome, especie, raca, dataChegada, dataNascimento) 
            VALUES (NULL, '" 
                . $this->conexao->real_escape_string($nome) . "', '"
                . $this->conexao->real_escape_string($especie) . "', '"
                . $this->conexao->real_escape_string($raca) . "', '"
                . $this->conexao->real_escape_string($dataChegada) . "', '"
                . $this->conexao->real_escape_string($dataNascimento) . "' )";

            return $this->executar_query($query);
        }

        public function deletar($nome){
            $query = "DELETE FROM animais WHERE nome = " . "'$nome'";
            return $this->executar_query($query);
        }

        public function atualizar($nome, $especie, $raca, $dataChegada, $dataNasci){
            $query = "UPDATE animais SET especie = " . "'$especie'" . ", raca =" . "'$raca'" . ", dataChegada =" . "'$dataChegada'" . ", dataNascimento =" . "'$dataNasci'"
                    . " WHERE nome =" . "'$nome'";
            print($query);
            return $this->executar_query($query);
        }

        public function consultar(){
            $query = "SELECT * FROM animais ORDER BY id";
            return $this->executar_query($query);
        }

        public function consultaByName($nome){
            $query = "SELECT * FROM animais WHERE nome = " . "'$nome'";
            return $this->executar_query($query);
        }

        public function formatData($data){
            $dia = substr($data, 0, 2);
            $mes = substr($data, 3, 2);
            $ano = substr($data, 6);
                    
            $datafinal = ($ano . "-" . $mes . "-" . $dia);
            return $datafinal;
        }


    }

?>