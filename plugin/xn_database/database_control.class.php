<?php

/*
 * Copyright (C) xgcms.com
 */

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

include BBS_PATH.'admin/control/admin_control.class.php';

class database_control extends admin_control {
	private $dbconf;
	private $db;
	private $data_path;
	
	function __construct(&$conf) {
		parent::__construct($conf);
		
		$this->check_admin_group();
		
		require $this->conf['plugin_path'].'/xn_database/mysql.class.php';
		
		$this->dbconf=$this->conf['db']['mysql']['master'];
		$this->db = new mysql($this->dbconf);
		$this->data_path=BBS_PATH.'databackup/';
		define('DB_PRE',$this->dbconf['tablepre']);
	}
	public function on_index(){
	    $rs=$this->db->query("SHOW TABLE STATUS FROM `".$this->dbconf['name']."`");
		$list=array();
		while($data = mysql_fetch_assoc($rs)) {
			$list[]=$data;
		}
		$this->view->assign('list',$list);
		$this->view->display('database_index.htm');
	}
	public function on_import(){
		$dosumit=core::gpc('dosubmit','G');
		if($dosumit) {
			$pre = trim(core::gpc('pre','R'));
			$fileid = trim(core::gpc('fileid','R'));
			$this->import_database($pre,$fileid);
		} else {

			$sqlfiles = glob($this->data_path.'*.sql');
			if(is_array($sqlfiles)) {
				asort($sqlfiles);
				$prebgcolor=$prepre = '';
				$info = $infos = $other = $others = array();
				foreach($sqlfiles as $id=>$sqlfile) {
					if(preg_match("/(xgcmstables_[0-9]{8}_[0-9a-z]{4}_)([0-9]+)\.sql/i",basename($sqlfile),$num)) {
						$info['filename'] = basename($sqlfile);
						$info['filesize'] = round(filesize($sqlfile)/(1024*1024), 2);
						$info['maketime'] = date('Y-m-d H:i:s', filemtime($sqlfile));
						$info['pre'] = $num[1];
						$info['number'] = $num[2];
						if(!$id) $prebgcolor = '#CFEFFF';
						if($info['pre'] == $prepre) {
						 $info['bgcolor'] = $prebgcolor;
						} else {
						 $info['bgcolor'] = $prebgcolor == '#CFEFFF' ? '#F1F3F5' : '#CFEFFF';
						}
						$prebgcolor = $info['bgcolor'];
						$prepre = $info['pre'];
						$infos[] = $info;
					} else {
						$other['filename'] = basename($sqlfile);
						$other['filesize'] = round(filesize($sqlfile)/(1024*1024),2);
						$other['maketime'] = date('Y-m-d H:i:s',filemtime($sqlfile));
						$others[] = $other;
					}
				}
			}
			
			$this->view->assign('list',$infos);
			$this->view->display('database_import.htm');
		}
		
		
		
	}
	public function on_backup(){
		
		$tables=core::gpc('tables','R');
		
			$sqlcharset =core::gpc('sqlcharset','R');
			$sqlcompat =core::gpc('sqlcompat','R');
			$sizelimit = core::gpc('sizelimit','R');
			$fileid =core::gpc('fileid','R'); 
			$random =core::gpc('random','R'); 
			$tableid =core::gpc('tableid','R'); 
			$startfrom =core::gpc('startfrom','R'); 
			$tabletype =core::gpc('tabletype','R');
		    $startrow =core::gpc('startrow','R'); 
		
		$this->export_database($tables,$sqlcompat,$sqlcharset,$sizelimit,$fileid,$random,$tableid,$startfrom,$tabletype,$startrow) ;
		
		
	}
	/**
	 * 备份文件删除
	 */
	public function on_delete() {
		$filenames = core::gpc('filenames','P');
		$bakfile_path = $this->data_path;
		if($filenames) {
			if(is_array($filenames)) {
				foreach($filenames as $filename) {
					if(stripos($filename,'.sql')) {
						@unlink($bakfile_path.$filename);
					}
				}
				$this->message('成功删除文件！',1,'?database-import.htm');
			} else {
				if(stripos($filename,'.sql')) {
					@unlink($bakfile_path.$filename);
					$this->message('成功删除文件！',1,'?database-import.htm');
				}
			}
		} else {
			$this->message('请选择需要删除的文件！');	
		}				
	}
	//下载备份
	public function on_down()
	{   
		$filename=core::gpc('filename','G');
		$fileext = $this->fileext($filename);
		if($fileext != 'sql')
		{
			$this->message('只允许下载sql文件！');
		}
		$this->file_down($this->data_path.$filename);

	}
		/**
	 * 数据库导出方法
	 * @param unknown_type $tables 数据表数据组
	 * @param unknown_type $sqlcompat 数据库兼容类型
	 * @param unknown_type $sqlcharset 数据库字符
	 * @param unknown_type $sizelimit 卷大小
	 * @param unknown_type $action 操作
	 * @param unknown_type $fileid 卷标
	 * @param unknown_type $random 随机字段
	 * @param unknown_type $tableid 
	 * @param unknown_type $startfrom 
	 * @param unknown_type $tabletype 备份数据库类型 （非phpcms数据与phpcms数据）
	 */
	private function export_database($tables,$sqlcompat,$sqlcharset,$sizelimit,$fileid,$random,$tableid,$startfrom,$tabletype,$startrow) {
		$dumpcharset = $sqlcharset ? $sqlcharset : str_replace('-', '', 'utf8');

		$fileid = ($fileid != '') ? $fileid : 1;		
		if($fileid==1 && $tables) {
			if(!isset($tables) || !is_array($tables)) $this->message('请选择备份数据表！');
			$random = mt_rand(1000, 9999);
			$this->cache_write('bakup_tables.php',$tables);
		} else {
			if(!$tables = $this->cache_read('bakup_tables.php')) $this->message('请选择备份数据表！');
		}
		if($this->db->version() > '4.1'){
			if($sqlcharset) {
				$this->db->query("SET NAMES '".$sqlcharset."';\n\n");
			}
			if($sqlcompat == 'MYSQL40') {
				$this->db->query("SET SQL_MODE='MYSQL40'");
			} elseif($sqlcompat == 'MYSQL41') {
				$this->db->query("SET SQL_MODE=''");
			}
		}
		
		$tabledump = '';

		$tableid = ($tableid!= '') ? $tableid  : 0;
		$startfrom = ($startfrom != '') ? intval($startfrom) : 0;
		for($i = $tableid; $i < count($tables) && strlen($tabledump) < $sizelimit * 1000; $i++) {
			$offset = 100;
			if(!$startfrom) {
				//if($tables[$i]!=DB_PRE.'session') {
					$tabledump .= "DROP TABLE IF EXISTS `$tables[$i]`;\n";
				//}
				$createtable = $this->db->query("SHOW CREATE TABLE `$tables[$i]` ");
				$create = $this->db->fetch_next();
				$tabledump .= $create['Create Table'].";\n\n";
				$this->db->free_result($createtable);
							
				if($sqlcompat == 'MYSQL41' && $this->db->version() < '4.1') {
					$tabledump = preg_replace("/TYPE\=([a-zA-Z0-9]+)/", "ENGINE=\\1 DEFAULT CHARSET=".$dumpcharset, $tabledump);
				}
				if($this->db->version() > '4.1' && $sqlcharset) {
					$tabledump = preg_replace("/(DEFAULT)*\s*CHARSET=[a-zA-Z0-9]+/", "DEFAULT CHARSET=".$sqlcharset, $tabledump);
				}
				if($tables[$i]==DB_PRE.'session') {
					$tabledump = str_replace("CREATE TABLE `".DB_PRE."online`", "CREATE TABLE IF NOT EXISTS `".DB_PRE."online`", $tabledump);
				}
			}

			$numrows = $offset;
			while(strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset) {
				if($tables[$i]==DB_PRE.'session' || $tables[$i]==DB_PRE.'member_cache') break;
				$sql = "SELECT * FROM `$tables[$i]` LIMIT $startfrom, $offset";
				$numfields = $this->db->num_fields($sql);
				$numrows = $this->db->num_rows($sql);
				$fields_name = $this->db->get_fields($tables[$i]);
				$rows = $this->db->query($sql);
				$name = array_keys($fields_name);
				$r = array();
				while ($row = $this->db->fetch_next()) {
					$r[] = $row;
					$comma = "";
					$tabledump .= "INSERT INTO `$tables[$i]` VALUES(";
					for($j = 0; $j < $numfields; $j++) {
						$tabledump .= $comma."'".mysql_escape_string($row[$name[$j]])."'";
						$comma = ",";
					}
					$tabledump .= ");\n";
				}
				$this->db->free_result($rows);
				$startfrom += $offset;
				
			}
			$tabledump .= "\n";
			$startrow = $startfrom;
			$startfrom = 0;
		}
		if(trim($tabledump)) {
			$tabledump = "# phpcms bakfile\n# version:xgcms post V3.1\n# time:".date('Y-m-d H:i:s')."\n# type:xgcms\n# xgcms:http://www.xgcms.com\n# --------------------------------------------------------\n\n\n".$tabledump;
			$tableid = $i;
			$filename = $tabletype.'_'.date('Ymd').'_'.$random.'_'.$fileid.'.sql';
			$altid = $fileid;
			$fileid++;
			$bakfile_path = $this->data_path;
			if(!is_writable($bakfile_path)) {
				$this->message($bakfile_path.'不存在或者不可写！');
			}
			$filename='xgcmstables'.$filename;
			$bakfile = $bakfile_path.DIRECTORY_SEPARATOR.$filename;
			file_put_contents($bakfile, $tabledump);
			@chmod($bakfile, 0777);
			//if(!EXECUTION_SQL) $filename = L('bundling').$altid.'#';
			$url="?database-backup-sizelimit-$sizelimit-sqlcompat-$sqlcompat-sqlcharset-$sqlcharset-tableid-$tableid-fileid-$fileid-startfrom-$startfrom-random-$random-tabletype-$tabletype.htm";
			$this->message('成功备份'.$filename,1,$url);
			//showmessage(L('bakup_file')." $filename ".L('bakup_write_succ'), '?m=admin&c=database&a=export&sizelimit='.$sizelimit.'&sqlcompat='.$sqlcompat.'&sqlcharset='.$sqlcharset.'&tableid='.$tableid.'&fileid='.$fileid.'&startfrom='.$startrow.'&random='.$random.'&dosubmit=1&tabletype='.$tabletype.'&allow='.$allow.'&pdo_select='.$this->pdo_name);
		} else {
		   $bakfile_path = $this->data_path;
		   file_put_contents($bakfile_path.'index.html','');
		   $this->cache_delete('bakup_tables.php');
		   $this->message('数据库备份完成',1,'?database-index.htm');
		}
	}
	/**
	 * 数据库恢复
	 * @param unknown_type $filename
	 */
	private function import_database($filename,$fileid=1) {
		$datapath=$this->data_path;
		if($filename && stripos($filename,'.sql')) {
			$filepath = $datapath.$filename;
			if(!file_exists($filepath)) $this->message(" $filepath 不存在！");
			$sql = file_get_contents($filepath);
			$this->sql_execute($sql);
			$this->message("$filename 成功还原！",1,'?database-import.htm');
		} else {
			$pre = $filename;
			$fileid = ($fileid != '') ? $fileid : 1;
			$filename = $filename.$fileid.'.sql';
			$filepath = $datapath.$filename;
			if(file_exists($filepath)) {
				$sql = file_get_contents($filepath);
				$this->sql_execute($sql);
				$fileid++;
				$this->message("备份文件 $filename 成功还原！",1,"?database-import-pre-".$pre."-fileid-".$fileid."-dosubmit-1.htm");
			} else {
				$this->message('数据还原成功！',1,'?database-import.htm');
			}
		}
	}
	/**
	 * 执行SQL
	 * @param unknown_type $sql
	 */
 	private function sql_execute($sql) {
	    $sqls = $this->sql_split($sql);
		if(is_array($sqls)) {
			foreach($sqls as $sql) {
				if(trim($sql) != '') {
					$this->db->query($sql);
				}
			}
		} else {
			$this->db->query($sqls);
		}
		return true;
	}
	private function sql_split($sql) {
		if($this->db->version() > '4.1') {
			$sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=utf8",$sql);
		}
		if(DB_PRE != "xg_") $sql = str_replace("`xg_", '`'.DB_PRE, $sql);
		$sql = str_replace("\r", "\n", $sql);
		$ret = array();
		$num = 0;
		$queriesarray = explode(";\n", trim($sql));
		unset($sql);
		foreach($queriesarray as $query) {
			$ret[$num] = '';
			$queries = explode("\n", trim($query));
			$queries = array_filter($queries);
			foreach($queries as $query) {
				$str1 = substr($query, 0, 1);
				if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
			}
			$num++;
		}
		return($ret);
	}		
function fileext($filename)
{
	return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}
function file_down($filepath, $filename = '')
{
	if(!$filename) $filename = basename($filepath);
	//if(is_ie()) $filename = rawurlencode($filename);
	$filetype = $this->fileext($filename);
	$filesize = sprintf("%u", filesize($filepath));
	if(ob_get_length() !== false) @ob_end_clean();
	header('Pragma: public');
	header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: pre-check=0, post-check=0, max-age=0');
	header('Content-Transfer-Encoding: binary');
	header('Content-Encoding: none');
	header('Content-type: '.$filetype);
	header('Content-Disposition: attachment; filename="'.$filename.'"');
	header('Content-length: '.$filesize);
	readfile($filepath);
	exit;
}	
	//缓存文件写入、读取、删除
function cache_read($file, $path = '', $iscachevar = 0)
{
	if(!$path) $path =$this->data_path;
	$cachefile = $path.$file;
	if(is_file($cachefile)){
	return @include $cachefile;
	}
	return false;
}
function cache_write($file, $array, $path = '')
{
	if(!is_array($array)) return false;
	$array = "<?php\nreturn ".var_export($array, true).";\n?>";
	$cachefile = ($path ? $path : $this->data_path).$file;
	$strlen = file_put_contents($cachefile, $array);
	@chmod($cachefile, 0777);
	return $strlen;
}

function cache_delete($file, $path = '')
{
	$cachefile = ($path ? $path : $this->data_path).$file;
	return @unlink($cachefile);
}
	
}


?>