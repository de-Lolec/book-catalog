<?php

namespace App\Actions;
use Illuminate\Support\Facades\Storage;

class SaveImageAction
{
    public function __invoke($request): string
    {
        if ($request->hasFile('image')) {
          $file = $request->file('image');
          $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

          $file->move(public_path('images'), $fileName);

          $path = asset('images/' . $fileName);

          return $path;
        };

        return null;
    }
}
