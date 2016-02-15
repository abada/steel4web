<li class="{{ (Request::is('gestordelotes')) ? 'active' : ''}}">
	<a href="{{ (Request::is('gestordelotes')) ? 'javascript:return false;' : url('gestordelotes?'.http_build_query($nav['query'])) }}">Conjuntos</a>
</li>
<li class="{{ (Request::is('gestordelotes/lotes*')) ? 'active' : ''}}">
	<a href="{{ (Request::is('gestordelotes/lotes*')) ? 'javascript:return false;' : url('gestordelotes/lotes?'.http_build_query($nav['query'])) }}">Lotes</a>
</li>
<li class="{{ (Request::is('gestordelotes/producao*')) ? 'active' : ''}}">
	<a href="{{ (Request::is('gestordelotes/producao*')) ? 'javascript:return false;' : url('gestordelotes/producao?'.http_build_query($nav['query'])) }}">Em Produção</a>
</li>
<li class="{{ (Request::is('gestordelotes/pecas*')) ? 'active' : ''}}">
	<a href="{{ (Request::is('gestordelotes/pecas*')) ? 'javascript:return false;' : url('gestordelotes/pecas?'.http_build_query($nav['query'])) }}">Peças</a>
</li>