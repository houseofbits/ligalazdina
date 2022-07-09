
//https://www.typescriptlang.org/docs/handbook/declaration-files/templates/global-d-ts.html
declare namespace Ecwid {

    type APILoadedCallbackType = () => void;
    type PageLoadedCallbackType = (page: any) => void;

    class Callable<T> {
        add(callback: T): void;
    }

    const OnAPILoaded: Callable<APILoadedCallbackType>;
    const OnPageLoaded: Callable<PageLoadedCallbackType>;

    function openPage(page: string, props?: any): void;
}