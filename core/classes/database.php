<?php

namespace core\classes;

use Exception;
use PDO;
use PDOException;

class Database
{
    // gestao da base de dados
    private $ligacao;

    private function ligar()
    {
        $this->ligacao = new PDO(
            'mysql:' .
                'host=' . MYSQL_SERVER . ';' .
                'dbname=' . MYSQL_DATABASE . ';' .
                'charset=' . MYSQL_CHARSET,
            MYSQL_USER,
            MYSQL_PASS,
            array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_PERSISTENT => false
            )
        );
        $this->ligacao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    //====================================================================================================
    private function desligar()
    {
        // fechar a ligacao
        $this->ligacao = null;
    }
    //====================================================================================================
    // Significa que podemos passar parametros ou nao 
    public function select($sql, $parametros = null)
    {
        $sql = trim($sql);

        if (!preg_match('/^SELECT/i', $sql)) {
            throw new Exception("Base de Dados - Metodo SELECT apenas aceita instrucoes SELECT.");
        }
        // Executa funcao de pesquisa de SQL
        $this->ligar();
        // todos os selects vao ter resultados
        $resultado = null;

        try {
            //Comuinicacao com a bd
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
                $resultado = $executar->fetchAll(\PDO::FETCH_CLASS);
            } else {
                $executar = $this->ligacao->query($sql);
                $executar->execute();
                $resultado = $executar->fetchAll(\PDO::FETCH_CLASS);
            }
        } catch (\PDOException $e) {
            return false;
        }
        $this->desligar();
        // devolve o resultado 
        return $resultado;
    }
    //====================================================================================================
    // Insert tambem vai ter o meu sql e ter parametros
    public function insert($sql, $parametros = null)
    {
        $sql = trim($sql);

        if (!preg_match('/^INSERT/i', $sql)) {
            throw new Exception("Base de Dados - Metodo INSERT apenas aceita instrucoes INSERT.");
        }
        // Executa funcao de pesquisa de SQL
        $this->ligar();
        // todos os selects vao ter resultados
        $resultado = null;

        try {
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (\PDOException $e) {
            return false;
        }
        $this->desligar();
    }
    //====================================================================================================
    // Update tambem vai ter o meu sql e ter parametros
    public function update($sql, $parametros = null)
    {
        $sql = trim($sql);

        if (!preg_match('/^UPDATE/i', $sql)) {
            throw new Exception("Base de Dados - Metodo UPDATE apenas aceita instrucoes UPDATE.");
        }
        // Executa funcao de pesquisa de SQL
        $this->ligar();
        // todos os selects vao ter resultados
        $resultado = false;

        try {
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $resultado = $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $resultado = $executar->execute();
            }
        } catch (\PDOException $e) {
            return false;
        }
        $this->desligar();
        return $resultado;
    }
    //====================================================================================================
    // Delete tambem vai ter o meu sql e ter parametros
    public function delete($sql, $parametros = null)
    {
        $sql = trim($sql);

        if (!preg_match('/^DELETE/i', $sql)) {
            throw new Exception("Base de Dados - Metodo DELETE apenas aceita instrucoes DELETE.");
        }
        // Executa funcao de pesquisa de SQL
        $this->ligar();
        // todos os selects vao ter resultados
        $resultado = false;

        try {
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $resultado = $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $resultado = $executar->execute();
            }
        } catch (\PDOException $e) {
            return false;
        }
        $this->desligar();
        return $resultado;
    }
    //====================================================================================================
    // STATEMENT tambem vai ter o meu sql e ter parametros
    public function statement($sql, $parametros = null)
    {
        $sql = trim($sql);

        if (preg_match('/^SELECT|^INSERT|^UPDATE|^DELETE/i', $sql)) {
            throw new Exception("Base de Dados - Metodo STATEMENT apenas aceita instrucoes SELECT, INSERT, UPDATE e DELETE.");
        }
        // Executa funcao de pesquisa de SQL
        $this->ligar();
        try {
            if (!empty($parametros)) {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute($parametros);
            } else {
                $executar = $this->ligacao->prepare($sql);
                $executar->execute();
            }
        } catch (\PDOException $e) {
            return false;
        }
        $this->desligar();
    }
}
