import './bootstrap';

/**
 * Livewire 3 ships its own Alpine instance, so Alpine is imported from Livewire's
 * bundle rather than started separately. Bundling it here is what lets us register
 * the Alpine plugins the views rely on: `x-clipboard` and `x-trap`.
 *
 * The layouts pair this with `@livewireScriptConfig` in place of `@livewireScripts`.
 */
import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard';
import focus from '@alpinejs/focus';

Alpine.plugin(Clipboard);
Alpine.plugin(focus);

Livewire.start();
