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

	"accepted"         => ":attribute Kabul edilmelidir.",
	"active_url"       => ":attribute Geçerli bir URL değildir.",
	"after"            => ":attribute şu tarihten sonra olmalidir :date.",
	"alpha"            => ":attribute sadece harf olmalidir.",
	"alpha_dash"       => ":attribute Harf,sayı ve işaret deneyiniz.",
	"alpha_num"        => ":attribute Sayı ve harften oluşmuştur.",
	"array"            => ":attribute array olmak zorundadır.",
	"before"           => ":attribute şu tarihten önce olmak zorundadır :date.",
	"between"          => array(
		"numeric" => ":attribute aralığında olmalıdır :min - :max.",
		"file"    => ":attribute aralığında olmalıdır :min - :max kilobytes.",
		"string"  => ":attribute aralığında olmalıdır :min - :max characters.",
		"array"   => ":attribute aralığında olmalıdır :min - :max items.",
	),
	"confirmed"        => ":attribute Doğrulama eşleşmiyor.",
	"date"             => ":attribute Geçerli bir tarih değildir.",
	"date_format"      => ":attribute Farmat ile uyuşmuyor :format.",
	"different"        => ":attribute ve :other farklı olmak zorundadır.",
	"digits"           => ":attribute :digits karakter olmalıdır.",
	"digits_between"   => ":attribute aralığında olmalıdır :min and :max digits.",
	"email"            => ":attribute format geçerli.",
	"exists"           => "Seçilen :attribute geçerli.",
	"image"            => ":attribute resim olmak zorundadır.",
	"in"               => "Seçilen :attribute geçersiz.",
	"integer"          => ":attribute integer olmak zorundadır.",
	"ip"               => ":attribute Geçerli bir IP adresi olmalıdır.",
	"max"              => array(
		"numeric" => ":attribute Şundan büyük olmamalıdır :max.",
		"file"    => ":attribute Şundan büyük olmamalıdır :max kilobytes.",
		"string"  => ":attribute Şundan büyük olmamalıdır :max characters.",
		"array"   => ":attribute Şundan büyük olmamalıdır :max items.",
	),
	"mimes"            => ":attribute dosya tipi şu olmalıdır: :values.",
	"min"              => array(
		"numeric" => ":attribute Şundan küçük olmalıdır :min.",
		"file"    => ":attribute Şundan küçük olmalıdır :min kilobytes.",
		"string"  => ":attribute Şundan küçük olmalıdır :min characters.",
		"array"   => ":attribute Şundan küçük olmalıdır :min items.",
	),
	"not_in"           => "Seçilen :attribute geçerlidir.",
	"numeric"          => ":attribute numara olmalıdır.",
	"regex"            => ":attribute format geçerlidir.",
	"required"         => ":attribute alan geçerlidir.",
	"required_if"      => ":attribute alan mecburidir ne zaman :other :value. ise",
	"required_with"    => ":attribute alan mecburidir :values geçerlidir.",
	"required_without" => ":attribute alan mecburidir :values geçerli değildir.",
	"same"             => ":attribute ve :other birbiriyle aynı olmalıdır.",
	"size"             => array(
		"numeric" => ":attribute Şöyle olmalıdır :size.",
		"file"    => ":attribute Şöyle olmalıdır :size kilobytes.",
		"string"  => ":attribute Şöyle olmalıdır :size characters.",
		"array"   => ":attribute Şöyle olmalıdır :size ürünler.",
	),
	"unique"           => ":attribute zaten alınmıştır.",
	"url"              => ":attribute format geçerlidir.",

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
