<?
namespace hvasoares\validations;
use hvasoares\validations;
function mustBeAModel($object){
	//try{
		notNull($object);
		mustHaveMethod($object,'id');
		methodMustHaveNoArgs($object,'id');
		mustBeAScalar($object->id());
		return $object;
/*	}catch(ValidationException $ex){
		throw new ValidationException("Not a model object, see previous errors. Line ".$ex->getLine().' '.$ex->getFile()
			, $ex);
	}*/
}

function redisKeyZset($r,$k){
	if($r->type($k)!=4)
		throwError("$k is not a zset");
	return $k;
}

function redisKeyExists($r,$k){
	if(!$r->exists($k))
		throwError("there's no $k in database");
	return $k;
}
?>
