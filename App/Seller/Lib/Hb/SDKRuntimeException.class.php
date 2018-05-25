<?php
/**
 * @author jy625
 */
namespace Seller\Lib\Hb;
class  SDKRuntimeException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}

}

?>