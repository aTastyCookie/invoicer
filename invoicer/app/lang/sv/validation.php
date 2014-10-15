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

	"accepted"         => ":attribute måste accepteras.",
	"active_url"       => ":attribute är inte en giltig URL.",
	"after"            => ":attribute måste vara ett datum efter :date.",
	"alpha"            => ":attribute får bara innehålla bokstäver.",
	"alpha_dash"       => ":attribute får bara innehålla bokstäver, siffror och bindesträck.",
	"alpha_num"        => ":attribute får bara innehålla bokstäver och siffror.",
	"array"            => ":attribute måste vara en lista (array).",
	"before"           => ":attribute måste vara ett datum före :date.",
	"between"          => array(
		"numeric" => ":attribute måste vara :min - :max.",
		"file"    => ":attribute måste vara :min - :max kilobyte.",
		"string"  => ":attribute måste vara :min - :max tecken.",
		"array"   => ":attribute måste innehålla :min - :max artiklar.",
	),
	"confirmed"        => "Bekräftelsen på :attribute stämmer inte.",
	"date"             => ":attribute är inte ett giltigt datum.",
	"date_format"      => ":attribute matchar inte formatet :format.",
	"different"        => ":attribute och :other får inte vara likadana.",
	"digits"           => ":attribute åste vara :digits siffror.",
	"digits_between"   => ":attribute måste vara mellan :min och :max siffror.",
	"email"            => "Formatet på :attribute är ogiltigt.",
	"exists"           => "Den valda :attribute är ogiltig.",
	"image"            => ":attribute måste vara en bild.",
	"in"               => "Den valda :attribute är ogiltig.",
	"integer"          => ":attribute måste vara en siffra.",
	"ip"               => ":attribute måste vara en giltig IP-adress.",
	"max"              => array(
		"numeric" => ":attribute får inte vara större än :max.",
		"file"    => ":attribute får inte var större än :max kilobyte.",
		"string"  => ":attribute får inte vara större än :max tecken.",
		"array"   => ":attribute får inte ha mer än :max artiklar.",
	),
	"mimes"            => ":attribute måste vara en fil av typen: :values.",
	"min"              => array(
		"numeric" => ":attribute måste vara minst :min.",
		"file"    => ":attribute måste vara minst :min kilobyte.",
		"string"  => ":attribute måste vara minst :min tecken.",
		"array"   => ":attribute måste ha minst :min artiklar.",
	),
	"not_in"           => "Den valda :attribute är ogiltig.",
	"numeric"          => ":attribute måste vara ett nummer.",
	"regex"            => "Formatet på :attribute stämmer inte.",
	"required"         => "Fältet :attribute är obligatoriskt.",
	"required_if"      => ":attribute är obligatoriskt när :other är :value.",
	"required_with"    => ":attribute är obligatoriskt när :values är tillgänglig.",
	"required_without" => ":attribute är obligatoriskt när :values inte är tillgänglig.",
	"same"             => ":attribute och :other måste stämma överrens.",
	"size"             => array(
		"numeric" => ":attribute måste vara :size.",
		"file"    => ":attribute måste vara :size kilobyte stor.",
		"string"  => ":attribute måste vara :size tecken.",
		"array"   => ":attribute måste innhålla :size artiklar.",
	),
	"unique"           => ":attribute är upptagen.",
	"url"              => "Formatet på :attribute stämmer inte.",

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
