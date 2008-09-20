<?php
Rhaco::import("resources.Message");
Rhaco::import("database.model.TableObjectBase");
Rhaco::import("database.model.DbConnection");
Rhaco::import("database.TableObjectUtil");
Rhaco::import("database.model.Table");
Rhaco::import("database.model.Column");
/**
 * #ignore
 * 
 */
class PackageTable extends TableObjectBase{
	/**  */
	var $id;
	/**  */
	var $name;
	/**  */
	var $summary;
	/**  */
	var $description;
	/**  */
	var $public;
	/**  */
	var $vote;
	/**  */
	var $created;
	/**  */
	var $updated;
	var $dependCharges;
	var $maintainers;


	function PackageTable($id=null){
		$this->__init__($id);
	}
	function __init__($id=null){
		$this->id = null;
		$this->name = null;
		$this->summary = null;
		$this->description = null;
		$this->public = 0;
		$this->vote = 0.000000;
		$this->created = time();
		$this->updated = time();
		$this->setId($id);
	}
	function connection(){
		if(!Rhaco::isVariable("_R_D_CON_","openpear")){
			Rhaco::addVariable("_R_D_CON_",new DbConnection("openpear"),"openpear");
		}
		return Rhaco::getVariable("_R_D_CON_",null,"openpear");
	}
	function table(){
		if(!Rhaco::isVariable("_R_D_T_","Package")){
			Rhaco::addVariable("_R_D_T_",new Table(Rhaco::constant("DATABASE_openpear_PREFIX")."package",__CLASS__),"Package");
		}
		return Rhaco::getVariable("_R_D_T_",null,"Package");
	}


	/**
	 * 
	 * @return database.model.Column
	 */
	function columnId(){
		if(!Rhaco::isVariable("_R_D_C_","Package::Id")){
			$column = new Column("column=id,variable=id,type=serial,size=22,primary=true,",__CLASS__);
			$column->label(Message::_("id"));
			$column->depend("Charge::Package");
			Rhaco::addVariable("_R_D_C_",$column,"Package::Id");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Package::Id");
	}
	/**
	 * 
	 * @return serial
	 */
	function setId($value){
		$this->id = TableObjectUtil::cast($value,"serial");
	}
	/**
	 * 
	 */
	function getId(){
		return $this->id;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnName(){
		if(!Rhaco::isVariable("_R_D_C_","Package::Name")){
			$column = new Column("column=name,variable=name,type=string,require=true,unique=true,chartype=/^[A-Za-z][A-Za-z0-9_]+$/,",__CLASS__);
			$column->label(Message::_("name"));
			Rhaco::addVariable("_R_D_C_",$column,"Package::Name");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Package::Name");
	}
	/**
	 * 
	 * @return string
	 */
	function setName($value){
		$this->name = TableObjectUtil::cast($value,"string");
	}
	/**
	 * 
	 */
	function getName(){
		return $this->name;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnSummary(){
		if(!Rhaco::isVariable("_R_D_C_","Package::Summary")){
			$column = new Column("column=summary,variable=summary,type=string,size=1000,",__CLASS__);
			$column->label(Message::_("summary"));
			Rhaco::addVariable("_R_D_C_",$column,"Package::Summary");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Package::Summary");
	}
	/**
	 * 
	 * @return string
	 */
	function setSummary($value){
		$this->summary = TableObjectUtil::cast($value,"string");
	}
	/**
	 * 
	 */
	function getSummary(){
		return $this->summary;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnDescription(){
		if(!Rhaco::isVariable("_R_D_C_","Package::Description")){
			$column = new Column("column=description,variable=description,type=text,",__CLASS__);
			$column->label(Message::_("description"));
			Rhaco::addVariable("_R_D_C_",$column,"Package::Description");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Package::Description");
	}
	/**
	 * 
	 * @return text
	 */
	function setDescription($value){
		$this->description = TableObjectUtil::cast($value,"text");
	}
	/**
	 * 
	 */
	function getDescription(){
		return $this->description;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnPublic(){
		if(!Rhaco::isVariable("_R_D_C_","Package::Public")){
			$column = new Column("column=public,variable=public,type=boolean,",__CLASS__);
			$column->label(Message::_("public"));
			Rhaco::addVariable("_R_D_C_",$column,"Package::Public");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Package::Public");
	}
	/**
	 * 
	 * @return boolean
	 */
	function setPublic($value){
		$this->public = TableObjectUtil::cast($value,"boolean");
	}
	/**
	 * 
	 */
	function getPublic(){
		return $this->public;
	}
	/**  */
	function isPublic(){
		return Variable::bool($this->public);
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnVote(){
		if(!Rhaco::isVariable("_R_D_C_","Package::Vote")){
			$column = new Column("column=vote,variable=vote,type=float,max=5,min=0,",__CLASS__);
			$column->label(Message::_("vote"));
			Rhaco::addVariable("_R_D_C_",$column,"Package::Vote");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Package::Vote");
	}
	/**
	 * 
	 * @return float
	 */
	function setVote($value){
		$this->vote = TableObjectUtil::cast($value,"float");
	}
	/**
	 * 
	 */
	function getVote(){
		return $this->vote;
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnCreated(){
		if(!Rhaco::isVariable("_R_D_C_","Package::Created")){
			$column = new Column("column=created,variable=created,type=timestamp,",__CLASS__);
			$column->label(Message::_("created"));
			Rhaco::addVariable("_R_D_C_",$column,"Package::Created");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Package::Created");
	}
	/**
	 * 
	 * @return timestamp
	 */
	function setCreated($value){
		$this->created = TableObjectUtil::cast($value,"timestamp");
	}
	/**
	 * 
	 */
	function getCreated(){
		return $this->created;
	}
	/**  */
	function formatCreated($format="Y/m/d H:i:s"){
		return DateUtil::format($this->created,$format);
	}
	/**
	 * 
	 * @return database.model.Column
	 */
	function columnUpdated(){
		if(!Rhaco::isVariable("_R_D_C_","Package::Updated")){
			$column = new Column("column=updated,variable=updated,type=timestamp,",__CLASS__);
			$column->label(Message::_("updated"));
			Rhaco::addVariable("_R_D_C_",$column,"Package::Updated");
		}
		return Rhaco::getVariable("_R_D_C_",null,"Package::Updated");
	}
	/**
	 * 
	 * @return timestamp
	 */
	function setUpdated($value){
		$this->updated = TableObjectUtil::cast($value,"timestamp");
	}
	/**
	 * 
	 */
	function getUpdated(){
		return $this->updated;
	}
	/**  */
	function formatUpdated($format="Y/m/d H:i:s"){
		return DateUtil::format($this->updated,$format);
	}


	function setDependCharges($value){
		$this->dependCharges = $value;
	}
	function getDependCharges(){
		return $this->dependCharges;
	}
	function setMaintainers($value){
		$this->maintainers = $value;
	}
	function getMaintainers(){
		return $this->maintainers;
	}
}
?>