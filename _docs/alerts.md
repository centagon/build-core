# Alerts

### Creating new alerts

```
alert()->secondary('my alert message');
alert()->primary('my alert message');
alert()->success('my alert message');
alert()->warning('my alert message');
alert()->alert('my alert message');
```

### Rendering alerts

```
@foreach (alert()->messages() as $key => $messages)
	@foreach ($messages as $message)
		<div class="panel panel--{{ $key }}">
			{{ $message }}
		</div>
	@endforeach
@endforeach
```

### Flashing alerts

Alerts can persist to the next request by flashing them:

```
alert()->success('my alert message.')->flash();
```