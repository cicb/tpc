<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	
	   private $_id;
    public function authenticate(){
        $username=strtolower($this->username);
        $user = Usuarios::model()->findAll(array('condition'=>"UsuariosNick= '$this->username' AND UsuariosPass='$this->password' AND UsuariosStatus='ALTA'"));
        if(empty($user))
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        /*else if($user->UsuariosPass!==$this->password)
            $this->errorCode=self::ERROR_PASSWORD_INVALID;*/
        else{
            $this->_id      = $user[0]->UsuariosId;
            $this->username = $user[0]->UsuariosNick;
            $this->errorCode=self::ERROR_NONE;
             
            /*Consultamos los datos del usuario por el username ($user->username) */
            //$info_usuario = Usuarios::model()->find('UsuariosNick)=?', array($user->UsuariosNick));
            /*En las vistas tendremos disponibles last_login y perfil pueden setear las que requieran */
            $this->setState('Admin',$user[0]->TipUsrId=="1"?true:false);
            $this->setState('TipUsrId',$user[0]->TipUsrId);
            $this->setState('accesos',$user[0]->Accesos());
             
            /*Actualizamos el last_login del usuario que se esta autenticando ($user->username) */
            //$sql = "update usuario set last_login = now() where username='$user->username'";
            //$connection = Yii::app() -> db;
            //$command = $connection -> createCommand($sql);
            //$command -> execute();
             
        }
        return $this->errorCode==self::ERROR_NONE;
    }
     
    public function getId(){
        return $this->_id;
    }
    /*public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	}*/
}