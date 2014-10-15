<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| such as the size rules. Feel free to tweak each of these messages.
	|
	*/

	"accepted"         => ":attribute debe ser aceptado.",
	"active_url"       => ":attribute no es una URL válida.",
	"after"            => ":attribute debe ser una fecha posterior a :date.",
	"alpha"            => ":attribute sólo puede contener letras.",
	"alpha_dash"       => ":attribute sólo puede contener letras, números y puntos.",
	"alpha_num"        => ":attribute sólo puede contener letras y números.",
	"array"            => ":attribute debe ser en orden.",
	"before"           => ":attribute debe ser una fecha anterior a :date.",
	"between"          => array(
		"numeric" => ":attribute debe estar entre :min - :max.",
		"file"    => ":attribute debe estar entre :min - :max kilobytes.",
		"string"  => ":attribute debe estar entre :min - :max characters.",
		"array"   => ":attribute debe tener entre :min - :max items.",
	),
	"confirmed"        => ":attribute confirmación no es válida.",
	"date"             => ":attribute no es una fecha válida.",
	"date_format"      => ":attribute no coincide con el formato de fecha :format.",
	"different"        => ":attribute y :other deben ser distintos.",
	"digits"           => ":attribute debe tener :digits digitos.",
	"digits_between"   => ":attribute debe tener entre :min y :max digitos.",
	"email"            => ":attribute formato no válido.",
	"exists"           => ":attribute seleccionado no es válido.",
	"image"            => ":attribute debe ser una imagen.",
	"in"               => ":attribute seleccionado no es válido.",
	"integer"          => ":attribute debe ser un entero.",
	"ip"               => ":attribute debe ser una IP válida.",
	"max"              => array(
		"numeric" => ":attribute no puede ser mayor de :max.",
		"file"    => ":attribute no puede tener mayor de :max kilobytes.",
		"string"  => ":attribute no puede tener mayor de :max caracteres.",
		"array"   => ":attribute no puede tener más de :max valores.",
	),
	"mimes"            => ":attribute debe ser un tipo de archivo: :values.",
	"min"              => array(
		"numeric" => ":attribute debe ser al menos :min.",
		"file"    => ":attribute debe tener al menos :min kilobytes.",
		"string"  => ":attribute debe tener al menos :min caracteres.",
		"array"   => ":attribute debe tener al menos :min valores.",
	),
	"not_in"           => ":attribute seleccionado no es válido.",
	"numeric"          => ":attribute debe ser numérico.",
	"regex"            => ":attribute tiene formato no válido.",
	"required"         => ":attribute es requerido.",
	"required_if"      => ":attribute es requerido cuando :other es :value.",
	"required_with"    => ":attribute es requerido cuando when :values está presente.",
	"required_without" => ":attribute es requerido cuando when :values no está presente.",
	"same"             => ":attribute y :other deben coincidir.",
	"size"             => array(
		"numeric" => ":attribute debe ser :size.",
		"file"    => ":attribute debe ser :size kilobytes.",
		"string"  => ":attribute debe ser :size characters.",
		"array"   => ":attribute debe contener :size artículos.",
	),
	"unique"           => ":attribute ya se ha usado, debe ser único.",
	"url"              => ":attribute formato inválido.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
