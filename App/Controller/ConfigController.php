<?php 
    use Model\Config;
    use Model\Config\Dao;

    class ConfigController{
        private $configDao;
        private $config;

        public function __construct()
        {
            $this->configDao = new ConfigDao();
            $this->config = new Config();
        }

        public function index(){
            $configs = $this->configDao->read();
            require_once __DIR__ . '/../Views/config.php';
            return $configs;
        }

        public function update($nome, $telefone, $email, $dias_permanencia, $endereco, $id){

            $this->config->setNome($nome);
            $this->config->setTelefone($telefone);
            $this->config->setEmail($email);
            $this->config->setDiasPermanencia($dias_permanencia);
            $this->config->setEndereco($endereco);
            $this->config->setId($id);

            $this->configDao->update($this->config);
        }
    }