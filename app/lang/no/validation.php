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

	"accepted"         => ":attribute må aksepteres.",
	"active_url"       => ":attribute er ikke en gyldig URL.",
	"after"            => ":attribute må være en dato etter :date.",
	"alpha"            => ":attribute kan bare inneholde bokstaver.",
	"alpha_dash"       => ":attribute kan bare inneholde bokstaver, tall og bindestreker.",
	"alpha_num"        => ":attribute kan bare inneholde bokstaver og tall.",
	"array"            => ":attribute må være en matrise.",
	"before"           => ":attribute må være en dato før :date.",
	"between"          => array(
		"numeric" => ":attribute må være mellom :min - :max.",
		"file"    => ":attribute må være mellom :min - :max kilobytes.",
		"string"  => ":attribute må være mellom :min - :max tegn.",
		"array"   => ":attribute må ha mellom :min - :max elementer.",
	),
	"confirmed"        => ":attribute bekreftelse stemmer ikke.",
	"date"             => ":attribute er ikke en gyldig dato.",
	"date_format"      => ":attribute ikke samsvarer med formatet :format.",
	"different"        => ":attribute og :other må være annerledes.",
	"digits"           => ":attribute må være :digits sifre.",
	"digits_between"   => ":attribute må være mellom :min og :max sifre.",
	"email"            => ":attribute formatet er ugyldig.",
	"exists"           => "Valgt :attribute er ugyldig.",
	"image"            => ":attribute må være et bilde.",
	"in"               => "Valgt :attribute er ugyldig.",
	"integer"          => ":attribute må være et helt tall.",
	"ip"               => ":attribute skal være en gyldig IP-adresse.",
	"max"              => array(
		"numeric" => ":attribute ikke kan være større enn :max.",
		"file"    => ":attribute ikke kan være større enn :max kilobytes.",
		"string"  => ":attribute ikke kan være større enn :max characters.",
		"array"   => ":attribute ikke kan ha mer enn :max elementer.",
	),
	"mimes"            => ":attribute må være en fil av typen: :values.",
	"min"              => array(
		"numeric" => ":attribute må være minst :min.",
		"file"    => ":attribute må være minst :min kilobytes.",
		"string"  => ":attribute må være minst :min bokstaver.",
		"array"   => ":attribute må ha minst :min elementer.",
	),
	"not_in"           => "Valgt :attribute er ugyldig.",
	"numeric"          => ":attribute må være et tall.",
	"regex"            => ":attribute formatet er ugyldig.",
	"required"         => ":attribute feltet er nødvendig.",
	"required_if"      => ":attribute felt er nødvendig når :other er :value.",
	"required_with"    => ":attribute felt er nødvendig når :values er til stede.",
	"required_without" => ":attribute felt er nødvendig når :values er ikke til stede.",
	"same"             => ":attribute og :other må stemme overens.",
	"size"             => array(
		"numeric" => ":attribute må være :size.",
		"file"    => ":attribute må være :size kilobytes.",
		"string"  => ":attribute må være :size bokstaver.",
		"array"   => ":attribute må inneholde :size elementer.",
	),
	"unique"           => ":attribute har allerede blitt tatt.",
	"url"              => ":attribute formatet er ugyldig.",

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
