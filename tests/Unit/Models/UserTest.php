<?php

declare(strict_types=1);

use App\Models\User;

/** The avatar in the header is the only thing that renders these. */
function initialsFor(string $name): string
{
    $user = new User;
    $user->name = $name;

    return $user->initials();
}

it('builds initials from a name', function (string $name, string $expected) {
    expect(initialsFor($name))->toBe($expected);
})->with([
    'a first and last name' => ['Owen Voke', 'OV'],
    'a single name' => ['Owen', 'O'],
    // More than two words still yields two letters, so the avatar never
    // overflows the space it is given.
    'a middle name' => ['Owen Michael Voke', 'OV'],
    'an initialised middle name' => ['Ada B. Lovelace', 'AL'],
    'a hyphenated first name' => ['Mary-Jane Watson', 'MW'],
    'an apostrophe' => ["O'Brien Smith", 'OS'],
]);

it('capitalises initials taken from a lowercase name', function () {
    expect(initialsFor('owen voke'))->toBe('OV');
});

it('ignores surrounding and repeated whitespace', function () {
    expect(initialsFor('  Owen   Voke  '))->toBe('OV');
});

it('returns nothing for a name with no letters', function (string $name) {
    expect(initialsFor($name))->toBe('');
})->with([
    'an empty name' => [''],
    'only whitespace' => [' '],
]);

it('handles a single character name', function () {
    expect(initialsFor('A'))->toBe('A');
});

it('handles multibyte names', function (string $name, string $expected) {
    expect(initialsFor($name))->toBe($expected);
})->with([
    'accented latin' => ['Renée Descartes', 'RD'],
    'cyrillic' => ['Ада Лавлейс', 'АЛ'],
]);
