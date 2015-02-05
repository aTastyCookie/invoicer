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
	| Translated to Estonian from BackOffice Services OÜ, Gunnar Michelson, info@backoffice.ee
	*/

	"accepted"         => ":attribute tuleb kinnitada.",
	"active_url"       => ":attribute ei ole weebiaadress.",
	"after"            => ":attribute peab olema pärast kuupäeva :date.",
	"alpha"            => ":attribute võib sisaldada ainult tähemärke.",
	"alpha_dash"       => ":attribute võib sisaldada ainult tähemärke, numbereid ja märke.",
	"alpha_num"        => ":attribute võib sisaldada ainult tähemärke ja numbereid.",
	"array"            => ":attribute peab olema arv.",
	"before"           => ":attribute peab olema enne kuupäeva :date.",
	"between"          => array(
		"numeric" => ":attribute peab olema vahemikus :min - :max.",
		"file"    => ":attribute peab olema vahemikus :min - :max kilobaiti.",
		"string"  => ":attribute peab olema vahemikus :min - :max tähemärki.",
		"array"   => ":attribute peab olema vahemikus :min - :max kaupu.",
	),
	"confirmed"        => ":attribute kordus ei ühti.",
	"date"             => ":attribute ei ole sobiv kuupäev.",
	"date_format"      => ":attribute ei ole sobivas formaadis :format.",
	"different"        => ":attribute ja :other peavad üksteisest erinema.",
	"digits"           => ":attribute peab olema :digits numbrit.",
	"digits_between"   => ":attribute olema vahemikus :min ja :max numbrit.",
	"email"            => ":attribute formaat on vale.",
	"exists"           => "Valitud :attribute on vigane.",
	"image"            => ":attribute peab olema pilt.",
	"in"               => "Valtud :attribute on vigane.",
	"integer"          => ":attribute peab olema täisarv.",
	"ip"               => ":attribute peab olema kehtiv IP aadress.",
	"max"              => array(
		"numeric" => ":attribute ei tohi olla suurem kui :max.",
		"file"    => ":attribute ei tohi olla suurem kui :max kilobaiti.",
		"string"  => ":attribute ei tohi olla suurem kui :max tähemärki.",
		"array"   => ":attribute ei tohi olla suurem kui :max items.",
	),
	"mimes"            => ":attribute failitüüp peab olema: :values.",
	"min"              => array(
		"numeric" => ":attribute peab olema vähemalt :min.",
		"file"    => ":attribute peab olema vähemalt :min kilobaiti.",
		"string"  => ":attribute peab olema vähemalt :min tähemärki.",
		"array"   => ":attribute peab olema vähemalt :min items.",
	),
	"not_in"           => "Valitud :attribute on vigane.",
	"numeric"          => ":attribute peab olema number.",
	"regex"            => ":attribute formaat on vigane.",
	"required"         => ":attribute väli on kohustuslik.",
	"required_if"      => ":attribute väli on kohustuslik kui :other on :value.",
	"required_with"    => ":attribute väli on kohustuslik kui :values on olemas.",
	"required_without" => ":attribute väli on kohustuslik kui :values ei ole olemas.",
	"same"             => ":attribute ja :other peavad kattuma.",
	"size"             => array(
		"numeric" => ":attribute peab olema :size.",
		"file"    => ":attribute peab olema :size kilobaiti.",
		"string"  => ":attribute peab olema :size tähemärki.",
		"array"   => ":attribute peab sisaldama :size items.",
	),
	"unique"           => ":attribute on juba kasutusel.",
	"url"              => ":attribute formaat on vale.",

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
