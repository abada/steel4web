<li class="{{ (Request::is('gestordelotes')) ? 'active' : ''}}">
	<a href="{{ (Request::is('gestordelotes')) ? 'javascript:return false;' : url('gestordelotes') }}">Conjuntos</a>
</li>
<li class="{{ (Request::is('gestordelotes/lotes*')) ? 'active' : ''}}">
	<a href="{{ (Request::is('gestordelotes/lotes*')) ? 'javascript:return false;' : url('gestordelotes/lotes') }}">Lotes</a>
</li>
<li class="{{ (Request::is('gestordelotes/producao*')) ? 'active' : ''}}">
	<a href="{{ (Request::is('gestordelotes/producao*')) ? 'javascript:return false;' : url('gestordelotes/producao') }}">Em Produção</a>
</li>
<li class="{{ (Request::is('gestordelotes/pecas*')) ? 'active' : ''}}">
	<a href="{{ (Request::is('gestordelotes/pecas*')) ? 'javascript:return false;' : url('gestordelotes/pecas') }}">Peças</a>
</li>