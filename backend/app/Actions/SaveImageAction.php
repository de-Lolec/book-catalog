<?php

namespace App\Actions;

class SaveImageAction
{
    public function __invoke($request): string
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $fileName);
        };

        return $path;
    }
}
