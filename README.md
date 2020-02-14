# Even pritier validation error blade directive

In my mind although this Laravel Blade directive is a major improvment it is still not the most elegant piece of code.
```
@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
```

I think we can do this better. Put this in a register method inside a AppServiceProvider.php
```
 Blade::directive('validation', function ($id) {
      return '<?php
          $__errorArgs = ['.$id.'];
          $__bag = $errors->getBag($__errorArgs[1] ?? \'default\');
          if ($__bag->has($__errorArgs[0])) :
              if (isset($message)) {
                  $__messageOriginal = $message;
              }
              $message = $__bag->first($__errorArgs[0]);
      ?>
          <span class="error">{{ $message }}</span>
      <?php
          unset($message);
          if (isset($__messageOriginal)) {
              $message = $__messageOriginal;
          }

          endif;
          unset($__errorArgs, $__bag);
      ?>';
  });

```

Then in your blade views you can use this like this:
```
@validation('email')
```

Slick, right?


