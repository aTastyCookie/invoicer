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

	"accepted"         => ":attribute πρέπει να γίνει αποδεκτό.",
	"active_url"       => ":attribute μη έγκυρh ηλεκτρονική διεύθυνση.",
	"after"            => ":attribute πρέπει να είναι ημερομηνία μετά από :date.",
	"alpha"            => ":attribute πρέπει να περιέχει μόνο γράμματα.",
	"alpha_dash"       => ":attribute μπορεί να περιέχει μόνο γράμματα, αριθμούς, και παύλες.",
	"alpha_num"        => ":attribute μπορεί να περιέχει μόνο γράμματα και αριθμούς.",
	"array"            => ":attribute πρέπει να είναι σειρά.",
	"before"           => ":attribute πρέπει να είναι ημερομηνία πριν από :date.",
	"between"          => array(
		"numeric" => ":attribute πρέπει να είναι μεταξύ :min - :max.",
		"file"    => ":attribute πρέπει να είναι μεταξύ :min - :max kilobytes.",
		"string"  => ":attribute πρέπει να είναι μεταξύ :min - :max χαρακτήρες.",
		"array"   => ":attribute πρέπει να έχει μεταξύ :min - :max αντικειμένων.",
	),
	"confirmed"        => ":attribute μη έγκυρος κωδικός επιβεβαίωσης.",
	"date"             => ":attribute μη έγκυρη ημερομηνία.",
	"date_format"      => ":attribute μη έγκυρος τύπος :format.",
	"different"        => ":attribute και :other πρέπει να είναι διαφορετικά.",
	"digits"           => ":attribute πρέπει να είναι :digits αριθμοί.",
	"digits_between"   => ":attribute πρέπει να είναι μεταξύ :min και :max αριθμών.",
	"email"            => ":attribute μη έγκυρος τύπος.",
	"exists"           => ":attribute δεν είναι έγκυρο.",
	"image"            => ":attribute πρέπει να είναι εικόνα.",
	"in"               => "Το επιλεγμένο :attribute δεν είναι έγκυρο.",
	"integer"          => ":attribute πρέπει να είναι ακέραιος αριθμός.",
	"ip"               => ":attribute πρέπει να είναι έγκυρη διεύθυνση IP.",
	"max"              => array(
		"numeric" => ":attribute δεν μπορεί να είναι μεγαλύτερο από :max.",
		"file"    => ":attribute δεν μπορεί να είναι μεγαλύτερο από :max kilobytes.",
		"string"  => ":attribute δεν μπορεί να είναι μεγαλύτερο από :max χαρακτήρες.",
		"array"   => ":attribute δεν μπορεί να έχει περισσότερα από :max αντικείμενα.",
	),
	"mimes"            => ":attribute πρέπει να είναι αρχείο τύπου: :values.",
	"min"              => array(
		"numeric" => ":attribute πρέπει να είναι τουλάχιστον :min.",
		"file"    => ":attribute πρέπει να είναι τουλάχιστον :min kilobytes.",
		"string"  => ":attribute πρέπει να είναι τουλάχιστον :min χαρακτήρες.",
		"array"   => ":attribute πρέπει να έχει τουλάχιστον :min αντικείμενα.",
	),
	"not_in"           => "Το επιλεγμένο :attribute δεν είναι έγκυρο.",
	"numeric"          => ":attribute πρέπει να είναι αριθμός.",
	"regex"            => ":attribute μη έγκυρος τύπος.",
	"required"         => ":attribute υποχρεωτικό πεδίο.",
	"required_if"      => ":attribute υποχρεωτικό πεδίο όταν :other είναι :value.",
	"required_with"    => ":attribute υποχρεωτικό πεδίο όταν :values υπάρχει.",
	"required_without" => ":attribute υποχρεωτικό πεδίο όταν :values δεν υπάρχει.",
	"same"             => ":attribute και :other πρέπει να είναι τα ίδια.",
	"size"             => array(
		"numeric" => ":attribute πρέπει να είναι :size.",
		"file"    => ":attribute πρέπει να είναι :size kilobytes.",
		"string"  => ":attribute πρέπει να είναι :size χαρακτήρες.",
		"array"   => ":attribute πρέπει να περιέχει :size αντικείμενα.",
	),
	"unique"           => ":attribute είναι ήδη κρατημένο.",
	"url"              => ":attribute μη έγκυρος τύπος.",

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
