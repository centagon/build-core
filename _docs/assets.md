# Assets

It's possible to add assets to the stack without adding them
manually in your view by using the `Asset` resource class.

### Adding stylesheet files

```
Build\Core\Support\Facades\Asset::addStylesheet('style.css');
```

### Inlining styles

```
Build\Core\Support\Facades\Asset::inlineStyle('body { color: red; }');
```

### Adding javascript files

```
Build\Core\Support\Facades\Asset::addJavascript('script.js');
```

### Inlining scripts

```
Build\Core\Support\Facades\Asset::inlineScript('alert("test");');
```