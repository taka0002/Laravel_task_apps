To doリストアプリ

Laravelを使用して、日々のtodoを管理するアプリを作成しました。

URL:http://takahiro-kym.sakura.ne.jp/task_app/public/task_apps

![todo](https://user-images.githubusercontent.com/63849657/99249661-cead7880-284d-11eb-926d-06688491818c.png)

「ここをクリックしてやること登録」を押すと入力部分が表示されるのでそこでやることを登録します。
登録されたTO DOに関しては、「未完了リスト」に一覧で表示されます。（締め切り日順で並んでいます）

![todo_todo](https://user-images.githubusercontent.com/63849657/99528801-2aa90600-29e2-11eb-94fb-93b26a4d849b.png)

このとき、締め切り日を入れなかった場合は「固定」扱い（毎日やること）として認識され、そのTO DOに関してはデフォルトで上位に黄色で表示されます。

![todo_solid](https://user-images.githubusercontent.com/63849657/99528453-a787b000-29e1-11eb-844d-a4e2ec658c99.png)

「ここをクリックしてカテゴリ登録」を押すと、今度はカテゴリの登録が可能。登録したカテゴリに関しては、「カテゴリーの編集はこちらから」で一覧で確認可能。
（カテゴリーに関しては、登録文言部分をクリックするとその場編集できるようになっています。）

![todo_category](https://user-images.githubusercontent.com/63849657/99528851-3e546c80-29e2-11eb-9539-009d5295111a.png)

![todo_category_edit](https://user-images.githubusercontent.com/63849657/99528566-d30a9a80-29e1-11eb-8eb9-5e5f73f23eec.png)

【こだわった点】

- 詳細ボタンを押すと、ポップアップで備考欄が表示される

![todo_popup](https://user-images.githubusercontent.com/63849657/99250233-aeca8480-284e-11eb-9317-aea1b736a434.gif)

- todoのリストは登録順ではなく、締め切り日の近い順から並べている（デフォルトの状態）
- 「現在のステータス」「締め切り期限」に関しては、selectで選択すればリストの並び替えが可能

![todo_status](https://user-images.githubusercontent.com/63849657/99250842-b179a980-284f-11eb-8ac4-ddb7c84e761c.gif)

- やることリストをその場編集できる
- その場編集したものに関しては、編集が完了した時点でenterを押すと、自動的にpostされて修正内容が保存される

![todo_change_1](https://user-images.githubusercontent.com/63849657/99251141-2d73f180-2850-11eb-9e1a-e4553bbcff18.gif)

- 現在のステータスに関しては、クリックした時点で「未着手」「着手中」にステータスを変えられる（着手中の場合は色が変更）

![todo_status](https://user-images.githubusercontent.com/63849657/99251558-e1757c80-2850-11eb-84fc-cab55ccbb0bb.gif)

- それぞれの締め切り期限の日にちをクリックすると、その場で締め切り日の変更が可能。変更ボタンを押すとpostされて変更可能

![todo_change_2](https://user-images.githubusercontent.com/63849657/99251702-25688180-2851-11eb-9f2f-5c67ea6114b6.gif)

- それぞれのタスクは、完了ボタンを押すと完了済みリストに移行される（アラートの表示）
なお、取り消しをボタンを押すと完了済みリストには入らず削除される

![todo_delete](https://user-images.githubusercontent.com/63849657/99529467-321cdf00-29e3-11eb-8bc7-247635c42c8d.gif)

【使用言語】 HTML/CSS、JavaScript、jQuery、PHP

【フレームワーク】 Laravel5.5

【DB】 MySQL

【環境構築】 Docker
