class Platform {
    register() {
        const platform = Platform.isMac() ? 'mac' : 'win';
        $('html').addClass(`platform-${platform}`);
    }

    static isMac() {
        return navigator.platform.indexOf('Mac') > -1
    }

    static isWindows() {
        return navigator.platform.indexOf('Win') > -1
    }
}

export default Platform;
