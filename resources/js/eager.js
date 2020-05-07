window.theLuck = window.theLuck || {};
window.theLuck.globals = window.theLuck.globals || {};
window.theLuck.set = function(key, value) {
    window.theLuck.globals[key] = value;
}
window.theLuck.get = function(key) {
    if(window.theLuck && window.theLuck.globals) {
        return window.theLuck.globals[key];
    }
}