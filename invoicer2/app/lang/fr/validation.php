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

	"accepted"         => ":attribute doit être accepté.",
	"active_url"       => ":attribute n'est pas une URL valide.",
	"after"            => ":attribute doit être une date postérieure à :date.",
	"alpha"            => ":attribute doit contenir uniquement des caractères alphabétiques.",
	"alpha_dash"       => ":attribute doit contenir uniquement des lettres, des chiffres, et des symboles dièses.",
	"alpha_num"        => ":attribute doit contenir uniquement des lettres et des chiffres.",
	"array"            => ":attribute doit être un tableau.",
	"before"           => ":attribute doit être une date antérieure à :date.",
	"between"          => array(
		"numeric" => ":attribute doit être compris entre :min et :max.",
		"file"    => ":attribute doit être compris entre :min et :max kilobits.",
		"string"  => ":attribute doit contenir :min à :max caractères.",
		"array"   => ":attribute doit contenir entre :min et :max éléments.",
	),
	"confirmed"        => "Le champ de confirmation :attribute ne correspond pas à la saisie.",
	"date"             => ":attribute n'est pas une date valide.",
	"date_format"      => ":attribute ne satisfait pas le format :format.",
	"different"        => ":attribute et :other doivent être différents.",
	"digits"           => ":attribute doit contenir :digits chiffres.",
	"digits_between"   => ":attribute doit être compris entre :min et :max chiffres.",
	"email"            => "Le format de :attribute est invalide.",
	"exists"           => "L'attribut sélectionné :attribute n'est pas invalide.",
	"image"            => ":attribute doit contenir une image.",
	"in"               => "L'attribut sélectionné :attribute n'est pas invalide.",
	"integer"          => ":attribute doit être un entier.",
	"ip"               => ":attribute doit être une adresse IP valide.",
	"max"              => array(
		"numeric" => ":attribute doit être supérieur à :max.",
		"file"    => ":attribute doit être supérieur à :max kilobits.",
		"string"  => ":attribute doit être supérieur à :max caractères.",
		"array"   => ":attribute doit contenir moins de :max éléments.",
	),
	"mimes"            => ":attribute doit être un fichier de type : :values.",
	"min"              => array(
		"numeric" => ":attribute doit être d'au moins :min.",
		"file"    => ":attribute doit être d'au moins :min kilobits.",
		"string"  => ":attribute doit être d'au moins :min caractères.",
		"array"   => ":attribute doit être d'au moins :min éléments.",
	),
	"not_in"           => "Le champ sélectionné :attribute est invalide.",
	"numeric"          => ":attribute doit être un nombre.",
	"regex"            => "Le format du champ :attribute est invalide.",
	"required"         => "Le champ :attribute est obligatoire.",
	"required_if"      => "Le champ :attribute est obligatoire lorsque :other est :value.",
	"required_with"    => "Le champ :attribute est obligatoire lorsque :values est présent.",
	"required_without" => "Le champ :attribute est obligatoire lorsque :values n'est pas présent.",
	"same"             => "Les champs :attribute et :other doivent correspondre.",
	"size"             => array(
		"numeric" => ":attribute doit être :size.",
		"file"    => ":attribute doit être :size kilobits.",
		"string"  => ":attribute doit être de :size caractères.",
		"array"   => ":attribute doit contenir :size éléments.",
	),
	"unique"           => ":attribute est déjà utilisé.",
	"url"              => "Le format :attribute est invalide.",

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
