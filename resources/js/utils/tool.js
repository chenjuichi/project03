
/**
   * @description: 在缓存中写入语言配置变量
   * @param {String} lang 语言代码，app.js 中初始化的
*/
export function setLang (lang) {
    var storage = window.localStorage;
    storage.setItem('vue-lang', lang);
}

/**
   * @description: 取當前语言變數,若無就設成英文,併返回
   * @return: 语言變數
*/
export function getLang () {
    var storage = window.localStorage;
    //var lang = storage.getItem('vue-lang') || 'en';
    var lang = storage.getItem('vue-lang');
    if (lang === null || lang === '') {    
      setLang('en');
      return 'en';
    } else {
      if (lang === '"cn"' || lang === '"en"') {
        return JSON.parse(lang);
      } else {
        return lang;
      }
    }
}
