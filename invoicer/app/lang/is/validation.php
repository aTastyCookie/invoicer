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

	"accepted"         => ":attribute verður að vera samþykkt.",
	"active_url"       => ":attribute er ekki gild slóð.",
	"after"            => ":attribute verður að vera dagsetning eftir :date.",
	"alpha"            => ":attribute má aðeins innihalda bókstafi.",
	"alpha_dash"       => ":attribute má aðeins innihalda bókstafi, tölur og bandstrik.",
	"alpha_num"        => ":attribute má aðeins innihalda bókstafi og tölur.",
	"array"            => ":attribute verður að vera fjöldi.",
	"before"           => ":attribute verður að vera dagsetning fyrir :date.",
	"between"          => array(
		"numeric" => ":attribute verður að vera á milli :min - :max.",
		"file"    => ":attribute verður að vera á milli :min - :max kílóbæt.",
		"string"  => ":attribute verður að vera á milli :min - :max bókstafa.",
		"array"   => ":attribute verður að vera á milli :min - :max liðir.",
	),
	"confirmed"        => ":attribute staðfesting passar ekki.",
	"date"             => ":attribute er ekki gild dagsetning.",
	"date_format"      => ":attribute passar ekki við sniðið :format.",
	"different"        => ":attribute og :other verða að vera mismunandi.",
	"digits"           => ":attribute verður að vera :digits tölur.",
	"digits_between"   => ":attribute verður að vera á milli :min og :max tölur.",
	"email"            => ":attribute sniðið er ógillt.",
	"exists"           => "Valið :attribute er ógillt.",
	"image"            => ":attribute verður að vera myndaskrá.",
	"in"               => "Valið :attribute er ógillt.",
	"integer"          => ":attribute verður að vera heiltala.",
	"ip"               => ":attribute verður að vera gild IP slóð.",
	"max"              => array(
		"numeric" => ":attribute má ekki vera meiri en :max.",
		"file"    => ":attribute má ekki vera meiri en :max kílóbæt.",
		"string"  => ":attribute má ekki vera meiri en :max bókstafir.",
		"array"   => ":attribute má ekki vera fleiri en :max liðir.",
	),
	"mimes"            => ":attribute must be a file of type: :values.",
	"min"              => array(
		"numeric" => ":attribute verður að vera minst :min.",
		"file"    => ":attribute verður að vera minst :min kílóbæt.",
		"string"  => ":attribute verður að vera minst :min bókstafir.",
		"array"   => ":attribute verður að innihalda minst :min liðir.",
	),
	"not_in"           => "Valið :attribute er ógilt.",
	"numeric"          => ":attribute verður að vera númer.",
	"regex"            => ":attribute sniðið er ógilt.",
	"required"         => ":attribute svæði er ógilt.",
	"required_if"      => ":attribute svæði er krafist þegar :other er :value.",
	"required_with"    => ":attribute svæði er krafist þegar :values er til staðar.",
	"required_without" => ":attribute svæði er krafist þegar :values er ekki til staðar.",
	"same"             => ":attribute og :other verða að passa.",
	"size"             => array(
		"numeric" => ":attribute verður að vera :size.",
		"file"    => ":attribute verður að vera :size kílóbæt.",
		"string"  => ":attribute verður að vera :size stafir.",
		"array"   => ":attribute verður að innihalda :size liði.",
	),
	"unique"           => ":attribute hefur þegar verið tekin.",
	"url"              => ":attribute sniðið er ógillt.",

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
