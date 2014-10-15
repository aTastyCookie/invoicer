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

	"accepted"         => ":attribute mora biti prihvaćeno.",
	"active_url"       => ":attribute nema unesenu ispravnu adresa.",
	"after"            => ":attribute mora biti datum nakon :date.",
	"alpha"            => ":attribute može sadržavati samo slova.",
	"alpha_dash"       => ":attribute može sadržavati samo slova, brojeve i povlake.",
	"alpha_num"        => ":attribute može sadržavati samo slova i brojeve.",
	"array"            => ":attribute mora biti niz.",
	"before"           => ":attribute mora biti datum prije :date.",
	"between"          => array(
		"numeric" => ":attribute mora imati između :min - :max.",
		"file"    => ":attribute mora imati između :min - :max kilobajta.",
		"string"  => ":attribute mora imati između :min - :max znakova.",
		"array"   => ":attribute mora imati između :min - :max stavki.",
	),
	"confirmed"        => ":attribute potvrda se ne poklapa.",
	"date"             => ":attribute nema valjan datum.",
	"date_format"      => ":attribute se ne poklapa s formatom :format.",
	"different"        => ":attribute i :other moraju biti različiti.",
	"digits"           => ":attribute mora imati :digits znamenki.",
	"digits_between"   => ":attribute mora imati između :min and :max znamenki.",
	"email"            => ":attribute format nije ispravan.",
	"exists"           => "Odabran :attribute nije ispravn.",
	"image"            => ":attribute mora biti slika.",
	"in"               => "Odabran :attribute nije ispravan.",
	"integer"          => ":attribute mora biti broj.",
	"ip"               => ":attribute mora biti ispravna IP adresa.",
	"max"              => array(
		"numeric" => ":attribute ne smije biti veće od :max.",
		"file"    => ":attribute ne smije biti veće od :max kilobajta.",
		"string"  => ":attribute ne smije biti veće od :max znakova.",
		"array"   => ":attribute ne smije biti veće od :max stavki.",
	),
	"mimes"            => ":attribute mora biti tip: :values.",
	"min"              => array(
		"numeric" => ":attribute mora imati najmanje :min.",
		"file"    => ":attribute mora biti najmanje :min kilobytes.",
		"string"  => ":attribute mora imati najmanje :min characters.",
		"array"   => ":attribute mora imati najmanje :min items.",
	),
	"not_in"           => ":attribute je neispravno.",
	"numeric"          => ":attribute mora biti broj.",
	"regex"            => ":attribute je neispravno.",
	"required"         => ":attribute je obvezno.",
	"required_if"      => ":attribute je obvezno kada :other je :value.",
	"required_with"    => ":attribute polje je obvezno kada je dostupna vrijednost :values.",
	"required_without" => ":attribute polje je obvezno kada :values nije dostupno.",
	"same"             => ":attribute i :other moraju biti jednaki.",
	"size"             => array(
		"numeric" => ":attribute mora biti :size.",
		"file"    => ":attribute mora biti :size kilobytes.",
		"string"  => ":attribute mora imati :size characters.",
		"array"   => ":attribute mora imati :size items.",
	),
	"unique"           => ":attribute je već zauzeto.",
	"url"              => ":attribute format je neispravan.",

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
