<?php 


    class ClientesModel extends Mysql
    {   
        private $intIdUsuario;
        private $strIdentificacion;
        private $strNombre;
        private $strApellido;
        private $intTelefono;
        private $strEmail;
        private $strPassword;
        private $strToken;
        private $intTipoId;
        private $strNit;
        private $strNomFiscal;
        private $strDirFiscal;

        public function __construct(){
            parent::__construct();
        }



        public function insertCliente($stringidentificacion, $stringnombre, $stringapellido, $inttelefono, $stringemail, $stringpassword, $inttipoid, $stringnit, $stringnomfiscal, $stringdirfiscal){

            $this->strIdentificacion = $stringidentificacion;
            $this->strNombre = $stringnombre;
            $this->strApellido = $stringapellido;
            $this->intTelefono = $inttelefono;
            $this->strEmail = $stringemail;
            $this->strPassword = $stringpassword;
            $this->intTipoId = $inttipoid;
            $this->strNit = $stringnit;
            $this->strNomFiscal = $stringnomfiscal;
            $this->strDirFiscal = $stringdirfiscal;
                
            $return = 0;
            $sql = "SELECT * FROM persona WHERE 
                    email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}' ";
            $request = $this->MostrarRegistros($sql);

            if(empty($request))
            {
                $query_insert  = "INSERT INTO persona(identificacion,nombres,apellidos,telefono,email_user,password,rolid,nit,nombrefiscal,direccionfiscal) 
                                VALUES(?,?,?,?,?,?,?,?,?,?)";
                $arrData = array($this->strIdentificacion,
                                $this->strNombre,
                                $this->strApellido,
                                $this->intTelefono,
                                $this->strEmail,
                                $this->strPassword,
                                $this->intTipoId,
                                $this->strNit,
                                $this->strNomFiscal,
                                $this->strDirFiscal);
                $request_insert = $this->insertar($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function selectClientes(){

            $sql = "SELECT idpersona,identificacion,nombres,apellidos,telefono,email_user,status
                    FROM persona 
                    WHERE rolid = 8 and status != 0 ";
            
            $request = $this->MostrarRegistros($sql);
            return $request;
        }

    }

?>