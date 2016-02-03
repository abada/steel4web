<?php

/**
 * Global helpers file with misc functions
 *
 */

if (!function_exists('app_name')) {
	/**
	 * Helper to grab the application name
	 *
	 * @return mixed
	 */
	function app_name() {
		return config('app.name');
	}
}

if (!function_exists('access')) {
	/**
	 * Access (lol) the Access:: facade as a simple function
	 */
	function access() {
		return app('access');
	}
}

if (!function_exists('javascript')) {
	/**
	 * Access the javascript helper
	 */
	function javascript() {
		return app('JavaScript');
	}
}

if (!function_exists('gravatar')) {
	/**
	 * Access the gravatar helper
	 */
	function gravatar() {
		return app('gravatar');
	}
}

if (!function_exists('getFallbackLocale')) {
	/**
	 * Get the fallback locale
	 *
	 * @return \Illuminate\Foundation\Application|mixed
	 */
	function getFallbackLocale() {
		return config('app.fallback_locale');
	}
}

if (!function_exists('getLanguageBlock')) {

	/**
	 * Get the language block with a fallback
	 *
	 * @param $view
	 * @param array $data
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	function getLanguageBlock($view, $data = []) {
		$components = explode("lang", $view);
		$current = $components[0] . "lang." . app()->getLocale() . "." . $components[1];
		$fallback = $components[0] . "lang." . getFallbackLocale() . "." . $components[1];

		if (view()->exists($current)) {
			return view($current, $data);
		} else {
			return view($fallback, $data);
		}
	}
}

if (!function_exists('getIcon')) {

	/**
	 * Get the language block with a fallback
	 *
	 * @param $view
	 * @param array $data
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	function getIcon($string = NULL) {

		$icons['viga-trelicada'] = 'trelica.png';
		$icons['viga-soldada'] = 'soldada.png';
		$icons['viga-caixao'] = 'caixao.png';
		$icons['viga-tubular'] = 'tubular.png';
		$icons['viga-composta'] = 'composta.png';
		$icons['viga'] = 'viga.png';
		$icons['pilar-trelicado'] = 'trelica.png';
		$icons['pilar-soldado'] = 'soldada.png';
		$icons['pilar-caixao'] = 'caixao.png';
		$icons['pilar-tubular'] = 'tubular.png';
		$icons['pilar-composto'] = 'composta.png';
		$icons['pilar'] = 'viga.png';
		$icons['trelica'] = 'trelica.png';
		$icons['torre'] = 'torre.png';
		$icons['chumbador'] = 'chumbador.png';
		$icons['chumbacao'] = 'chumbador.png';
		$icons['console'] = 'console.png';
		$icons['misula'] = 'console.png';
		$icons['tensor'] = 'tensor.png';
		$icons['terca'] = 'terca.png';
		$icons['purlin'] = 'terca.png';
		$icons['flexal'] = 'tirante.png';
		$icons['fleixal'] = 'tirante.png';
		$icons['tirante'] = 'tirante.png';
		$icons['contravento'] = 'contravento.png';
		$icons['ctv'] = 'contravento.png';
		$icons['joist'] = 'joist.png';
		$icons['corrente-rigida'] = 'corrente.png';
		$icons['corrente-flexivel'] = 'corrente.png';
		$icons['corrente'] = 'corrente.png';
		$icons['mao-francesa'] = 'maofrancesa.png';
		$icons['mao-francesa'] = 'maofrancesa.png';
		$icons['longarina'] = 'escada.png';
		$icons['escada-lance'] = 'escada.png';
		$icons['escada-marinheiro'] = 'marinheiro.png';
		$icons['escada'] = 'escada.png';
		$icons['corrimao'] = 'corrimao.png';
		$icons['guarda-corpo'] = 'corrimao.png';
		$icons['guarda-corpo'] = 'corrimao.png';
		$icons['para-raio'] = 'pararraio.png';
		$icons['para-raio'] = 'pararraio.png';
		$icons['conector'] = 'conector.png';
		$icons['stud-bolt'] = 'conector.png';
		$icons['stud-bolt'] = 'conector.png';
		$icons['linha-de-vida'] = 'linhavida.png';
		$icons['linha-vida'] = 'linhavida.png';
		$icons['linha-vida'] = 'linhavida.png';
		$icons['grade-piso'] = 'gradepiso.png';
		$icons['grade-de-piso'] = 'gradepiso.png';
		$icons['chapa-expandida'] = 'gradepiso.png';
		$icons['chapa-xadrez'] = 'gradepiso.png';
		$icons['chapa-unit'] = 'chapa.png';
		$icons['chapa'] = 'chapa.png';
		$icons['lanternim'] = 'lanternim.png';
		$icons['exaustor'] = 'lanternim.png';
		$icons['placa-prismatica'] = 'zenital.png';
		$icons['placa-prism'] = 'zenital.png';
		$icons['zenital'] = 'zenital.png';
		$icons['degrau-de-grade'] = 'gradepiso.png';
		$icons['degrau-grade'] = 'gradepiso.png';
		$icons['degrau'] = 'degrau.png';
		$icons['veneziana'] = 'esquadria.png';
		$icons['esquadria'] = 'esquadria.png';
		$icons['tela'] = 'tela.png';
		$icons['tela-passarinheira'] = 'tela.png';
		$icons['passarela'] = 'passarela.png';
		$icons['suporte'] = 'suporte.png';
		$icons['apoio'] = 'suporte.png';
		$icons['perfil-unit'] = 'perfil.png';
		$icons['perfil'] = 'perfil.png';
		$icons['tubo'] = 'perfil.png';
		$icons['cartola'] = 'cartola.png';
		$icons['barra-rosc'] = 'barraroscada.png';
		$icons['barra-roscada'] = 'barraroscada.png';
		$icons['telha'] = 'telha.png';
		$icons['steel-deck'] = 'telha.png';
		$icons['steel-deck'] = 'telha.png';
		$icons['arremate'] = 'calha.png';
		$icons['rufo'] = 'calha.png';
		$icons['pingadeira'] = 'calha.png';
		$icons['calha'] = 'calha.png';
		$icons['suporte-de-calha'] = 'supcalha.png';
		$icons['suporte-calha'] = 'supcalha.png';
		$icons['sup-calha'] = 'supcalha.png';
		$icons['apoio-calha'] = 'supcalha.png';
		$icons['caixa-pressao'] = 'calha.png';
		$icons['caixa-coleta'] = 'calha.png';
		$icons['caixa-de-coleta'] = 'calha.png';
		$icons['grade-ralo'] = 'ralo.png';
		$icons['grade-abacaxi'] = 'ralo.png';
		$icons['grade-calha'] = 'ralo.png';
		$icons['diversos'] = 'diversos.png';
		$icons['acessorios'] = 'diversos.png';

		$string = strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));

		if (array_key_exists($string, $icons)) {
			return $icons[$string];
		} else {
			return $icons['diversos'];
		}

	}
}