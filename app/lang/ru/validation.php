<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| following language lines contain default error messages used by
	| validator class. Some of these rules have multiple versions such
	| such as size rules. Feel free to tweak each of these messages.
	|
	*/

	"accepted"         => ":attribute должен быть принят.",
	"active_url"       => ":attribute содержит неверный URL.",
	"after"            => ":attribute должен быть после :date.",
	"alpha"            => ":attribute может содержать только буквы.",
	"alpha_dash"       => ":attribute может содержать только буквы, цифры и дефис.",
	"alpha_num"        => ":attribute может содержать только буквы и цифры.",
	"array"            => ":attribute должен быть массивом.",
	"before"           => ":attribute должен быть дотой до :date.",
	"between"          => array(
		"numeric" => ":attribute должен быть в интервале :min - :max.",
		"file"    => ":attribute должен быть в интервале :min - :max килобайт.",
		"string"  => ":attribute должен быть в интервале :min - :max символов.",
		"array"   => ":attribute должны быть между :min - :max.",
	),
	"confirmed"        => ":attribute confirmation does not match.",
	"date"             => ":attribute is not a valid date.",
	"date_format"      => ":attribute does not match format :format.",
	"different"        => ":attribute and :other must be different.",
	"digits"           => ":attribute must be :digits digits.",
	"digits_between"   => ":attribute должен быть в интервале :min and :max digits.",
	"email"            => ":attribute format is invalid.",
	"exists"           => "selected :attribute is invalid.",
	"image"            => ":attribute must be an image.",
	"in"               => "selected :attribute is invalid.",
	"integer"          => ":attribute must be an integer.",
	"ip"               => ":attribute must be a valid IP address.",
	"max"              => array(
		"numeric" => ":attribute may not be greater than :max.",
		"file"    => ":attribute may not be greater than :max kilobytes.",
		"string"  => ":attribute may not be greater than :max characters.",
		"array"   => ":attribute may not have more than :max items.",
	),
	"mimes"            => ":attribute must be a file of type: :values.",
	"min"              => array(
		"numeric" => ":attribute must be at least :min.",
		"file"    => ":attribute must be at least :min kilobytes.",
		"string"  => ":attribute must be at least :min characters.",
		"array"   => ":attribute must have at least :min items.",
	),
	"not_in"           => "selected :attribute is invalid.",
	"numeric"          => ":attribute must be a number.",
	"regex"            => ":attribute format is invalid.",
	"required"         => ":attribute field is required.",
	"required_if"      => ":attribute field is required when :other is :value.",
	"required_with"    => ":attribute field is required when :values is present.",
	"required_without" => ":attribute field is required when :values is not present.",
	"same"             => ":attribute and :other must match.",
	"size"             => array(
		"numeric" => ":attribute must be :size.",
		"file"    => ":attribute must be :size kilobytes.",
		"string"  => ":attribute must be :size characters.",
		"array"   => ":attribute must contain :size items.",
	),
	"unique"           => ":attribute has already been taken.",
	"url"              => ":attribute format is invalid.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),

);
