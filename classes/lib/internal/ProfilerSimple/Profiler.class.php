<?php
/*-------------------------------------------------------
*
*   LiveStreet Engine Social Networking
*   Copyright © 2008 Mzhelskiy Maxim
*
*--------------------------------------------------------
*
*   Official site: www.livestreet.ru
*   Contact e-mail: rus.engine@gmail.com
*
*   GNU General Public License, version 2:
*   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
---------------------------------------------------------
*/
/**
 * Ведение профайлинга
 *
 */
class ProfilerSimple {
	
	static protected $oInstance=null;
	protected $aTimes;
	protected $sRequestId;
	protected $iTimeId;
	protected $iTimePidCurrent=null;
	protected $bEnable;
	protected $sFileName=null;
	 
	
	
	protected function __construct($sFileName,$bEnable) {
		$this->bEnable=$bEnable;
		$this->sFileName=$sFileName;
		$this->sRequestId=func_generator(32);
		$this->iTimeId=0;		
	}	
	/**
	 * Ограничиваем объект только одним экземпляром
	 *
	 * @return ProfilerSimple
	 */
	static public function getInstance($sFileName=null,$bEnable=true) {
		if (isset(self::$oInstance)) {
			return self::$oInstance;
		} else {
			self::$oInstance= new self($sFileName,$bEnable);
			return self::$oInstance;
		}
	}
	
	public function Start($sName,$sComment='') {
		if (!$this->bEnable) {
			return false;
		}
		$this->iTimeId++;
		$this->aTimes[$this->sRequestId.$this->iTimeId]=array(
			'request_id' => $this->sRequestId,
			'time_id' => $this->iTimeId,
			'time_pid' => $this->iTimePidCurrent,
			'time_name' => $sName,
			'time_comment' => $sComment,
			'time_start' => microtime(true),
		);		
		$this->iTimePidCurrent=$this->iTimeId;
		return $this->iTimeId;
	}
	
	public function Stop($iTimeId) {		
		if (!$this->bEnable or !$iTimeId or !isset($this->aTimes[$this->sRequestId.$iTimeId])) {
			return false;
		}		
		$this->aTimes[$this->sRequestId.$iTimeId]['time_stop']=microtime(true);
		$this->aTimes[$this->sRequestId.$iTimeId]['time_full']=$this->aTimes[$this->sRequestId.$iTimeId]['time_stop']-$this->aTimes[$this->sRequestId.$iTimeId]['time_start'];		
		$this->iTimePidCurrent=$this->aTimes[$this->sRequestId.$iTimeId]['time_pid'];		
	}
	
	public function Save() {
		if (!$this->bEnable or !$this->sFileName) {
			return false;
		}		
		if ($fp=fopen($this->sFileName,"a")) {
			foreach ($this->aTimes as $aTime) {
				$s=date('Y-m-d H:i:s')."\t{$aTime['request_id']}\t{$aTime['time_full']}\t{$aTime['time_start']}\t{$aTime['time_stop']}\t{$aTime['time_id']}\t{$aTime['time_pid']}\t{$aTime['time_name']}\t{$aTime['time_comment']}\r\n";
				fwrite($fp,$s);
			}			
			fclose($fp);			
		}
	}
	
	public function __destruct() {
		$this->Save();
	}
}
?>