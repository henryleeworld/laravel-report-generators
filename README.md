# Laravel 7 報告產生器

引入 jimmyjs 的 laravel-report-generator 套件來擴增快速生成簡單的 Pdf、CSV 和 Excel 報告，產生可供列印且符合排版需求的文件。

## 使用方式
- 把整個專案複製一份到你的電腦裡，這裡指的「內容」不是只有檔案，而是指所有整個專案的歷史紀錄、分支、標籤等內容都會複製一份下來。
```sh
$ git clone
```
- 將 __.env.example__ 檔案重新命名成 __.env__，如果應用程式金鑰沒有被設定的話，你的使用者 sessions 和其他加密的資料都是不安全的！
- 當你的專案中已經有 composer.lock，可以直接執行指令以讓 Composer 安裝 composer.lock 中指定的套件及版本。
```sh
$ composer install
```
- 產生 Laravel 要使用的一組 32 字元長度的隨機字串 APP_KEY 並存在 .env 內。
```sh
$ php artisan key:generate
```
- 執行 __Artisan__ 指令的 __migrate__ 來執行所有未完成的遷移，並執行資料庫填充（如果要測試的話）。
```sh
$ php artisan migrate --seed
```
- 在瀏覽器中輸入已定義的路由 URL 來訪問，例如：http://127.0.0.1:8000。
- 你可以經由 `/report/display/{csv|excel|pdf}` 來進行產生報告。

----

## 畫面截圖
![](https://i.imgur.com/mGpNitD.png)
> .csv（以逗號分隔）格式的檔案是以 UTF-8 編碼

![](https://i.imgur.com/bI53CAJ.png)
> .xlsx 格式從 Excel 2007 開始，XLSX 是 XML 格式，而且從 Excel 2007 開始是預設格式

![](https://i.imgur.com/eI4lT8h.png)
> .pdf（可攜式文件格式）檔案可使用 Adobe Reader 瀏覽