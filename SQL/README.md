# ステップ1

- テーブル：genres

| カラム名|データ型 |NULL| キー|初期値 |AUTO INCREMENT|
|:----------|-----------:|:-----------|:----------|-----------:|:-----------|
| genre_id    |  INTEGER |         | PRIMARY   |       |  YES   |
| genre_name   |   varchar(20) |       | UNIQUE   |     |     |



# STEP3
### 1,
```
SELECT episode_name AS エピソードタイトル, view_number AS 視聴数 FROM episodes ORDER BY view_number DESC LIMIT 3;
```

- 出力結果：
+--------------+-------------+
| episode_name | view_number |
+--------------+-------------+
| 半沢、再起動 |     6560000 |
| 鬼の力を知る |      800000 |
| セルの恐怖   |      800000 |
+--------------+-------------+


### 2,
```
SELECT
programs.program_name AS '番組タイトル',
COUNT(seasons.season_id) AS 'シーズン数',
COUNT(episodes.episode_id) AS 'エピソード数',
episodes.episode_name AS 'エピソードタイトル',
episodes.view_number AS '視聴数'
FROM programs
INNER JOIN series ON programs.program_id = series.program_id
INNER JOIN seasons ON series.series_id = seasons.series_id
INNER JOIN episodes ON seasons.season_id = episodes.season_id
GROUP BY programs.program_name, episodes.episode_name, episodes.view_number
ORDER BY COUNT(episodes.episode_id) DESC LIMIT 3;
```

- 出力結果：
+--------------+------------+--------------+--------------------+--------+
| 番組タイトル | シーズン数 | エピソード数 | エピソードタイトル | 視聴数 |
+--------------+------------+--------------+--------------------+--------+
| 鬼滅の刃     |          1 |            1 | 鬼殺隊入隊         | 700000 |
| 鬼滅の刃     |          1 |            1 | 炭治郎の誓い       | 100000 |
| 鬼滅の刃     |          1 |            1 | 鬼殺隊の仲間たち   | 200000 |
+--------------+------------+--------------+--------------------+--------+


### 3,
```
SELECT
channels.channel_name AS 'チャンネル名',
program_schedules.release_date AS '放送開始時刻',
program_schedules.release_date + INTERVAL program_schedules.episode_time MINUTE AS '放送終了時刻',
COUNT(seasons.season_id) AS 'シーズン数',
COUNT(episodes.episode_id) AS 'エピソード数',
episodes.episode_name AS 'エピソードタイトル',
episodes.episode_description AS 'エピソード詳細'
FROM program_schedules
INNER JOIN episodes ON program_schedules.episode_id = episodes.episode_id
INNER JOIN channels ON channels.channel_id = program_schedules.channel_id
INNER JOIN seasons ON episodes.season_id = seasons.season_id
GROUP BY channels.channel_name, program_schedules.release_date, program_schedules.episode_time, episodes.episode_name, episodes.episode_description;
```

- 出力結果：
+--------------+---------------------+---------------------+------------+--------------+--------------------+----------------+
| チャンネル名 | 放送開始時刻        | 放送終了時刻        | シーズン数 | エピソード数 | エピソードタイトル | エピソード詳細 |
+--------------+---------------------+---------------------+------------+--------------+--------------------+----------------+
| NHK          | 2025-02-05 01:00:00 | 2025-02-05 01:30:00 |          1 |            1 | ナメック星         | 見てください   |
| NHK          | 2025-02-05 03:30:00 | 2025-02-05 04:00:00 |          1 |            1 | 龍馬の歩み         | 見てください   |
| TBS          | 2025-02-05 00:30:00 | 2025-02-05 01:00:00 |          1 |            1 | 巨人の恐怖         | 見てください   |
| TBS          | 2025-02-05 03:00:00 | 2025-02-05 03:30:00 |          1 |            1 | 半沢、再起動       | 見てください   |
| テレビ朝日   | 2025-02-05 00:00:00 | 2025-02-05 00:30:00 |          1 |            1 | 鬼殺隊入隊         | 見てください   |
| テレビ朝日   | 2025-02-05 02:30:00 | 2025-02-05 03:00:00 |          1 |            1 | 相棒の誓い         | 見てください   |
| フジテレビ   | 2025-02-05 01:30:00 | 2025-02-05 02:00:00 |          1 |            1 | 海賊の誇り         | 見てください   |
| フジテレビ   | 2025-02-05 04:00:00 | 2025-02-05 04:30:00 |          1 |            1 | コンフィデンスマン | 見てください   |
| 日本テレビ   | 2025-02-05 02:00:00 | 2025-02-05 02:30:00 |          1 |            1 | 黒の暴牛           | 見てください   |
| 日本テレビ   | 2025-02-05 04:30:00 | 2025-02-05 05:00:00 |          1 |            1 | 北海道の大自然     | 見てください   |
+--------------+---------------------+---------------------+------------+--------------+--------------------+----------------+


### 4,
```
SELECT
genres.genre_name AS 'ジャンル名',
program_schedules.release_date AS '放送開始時刻',
program_schedules.release_date + INTERVAL program_schedules.episode_time MINUTE AS '放送終了時刻',
COUNT(seasons.season_id) AS 'シーズン数',
COUNT(episodes.episode_id) AS 'エピソード数',
episodes.episode_name AS 'エピソードタイトル',
episodes.episode_description AS 'エピソード詳細'
FROM program_schedules
INNER JOIN episodes ON program_schedules.episode_id = episodes.episode_id
INNER JOIN channels ON channels.channel_id = program_schedules.channel_id
INNER JOIN seasons ON episodes.season_id = seasons.season_id
INNER JOIN programs ON program_schedules.channel_id = programs.channel_id
INNER JOIN genres ON programs.genre_id = genres.genre_id
WHERE release_date >= (NOW() - INTERVAL 7 DAY)
AND genres.genre_id = 1
GROUP BY channels.channel_name, program_schedules.release_date, program_schedules.episode_time, episodes.episode_name, episodes.episode_description;
```

- 出力結果：
+------------+---------------------+---------------------+------------+--------------+--------------------+----------------+
| ジャンル名 | 放送開始時刻        | 放送終了時刻        | シーズン数 | エピソード数 | エピソードタイトル | エピソード詳細 |
+------------+---------------------+---------------------+------------+--------------+--------------------+----------------+
| ドラマ     | 2025-02-05 00:00:00 | 2025-02-05 00:30:00 |          1 |            1 | 鬼殺隊入隊         | 見てください   |
| ドラマ     | 2025-02-05 00:30:00 | 2025-02-05 01:00:00 |          1 |            1 | 巨人の恐怖         | 見てください   |
| ドラマ     | 2025-02-05 01:00:00 | 2025-02-05 01:30:00 |          1 |            1 | ナメック星         | 見てください   |
| ドラマ     | 2025-02-05 01:30:00 | 2025-02-05 02:00:00 |          1 |            1 | 海賊の誇り         | 見てください   |
| ドラマ     | 2025-02-05 02:30:00 | 2025-02-05 03:00:00 |          1 |            1 | 相棒の誓い         | 見てください   |
| ドラマ     | 2025-02-05 03:00:00 | 2025-02-05 03:30:00 |          1 |            1 | 半沢、再起動       | 見てください   |
| ドラマ     | 2025-02-05 03:30:00 | 2025-02-05 04:00:00 |          1 |            1 | 龍馬の歩み         | 見てください   |
| ドラマ     | 2025-02-05 04:00:00 | 2025-02-05 04:30:00 |          1 |            1 | コンフィデンスマン | 見てください   |
+------------+---------------------+---------------------+------------+--------------+--------------------+----------------+


### 5,
```
SELECT
episodes.episode_name AS '番組タイトル',
episodes.view_number AS '視聴数'
FROM program_schedules
INNER JOIN episodes ON program_schedules.episode_id = episodes.episode_id
WHERE release_date >= (NOW() - INTERVAL 7 DAY)
ORDER BY view_number DESC LIMIT 2;
```

- 出力結果：
+--------------+---------+
| 番組タイトル | 視聴数  |
+--------------+---------+
| 半沢、再起動 | 6560000 |
| 鬼殺隊入隊   |  700000 |
+--------------+---------+


### 6,
```
SELECT
genre_name AS 'ジャンル名',
programs.program_name AS '番組タイトル',
AVG(episodes.view_number) AS 'エピソード平均視聴数' 
FROM genres
INNER JOIN programs ON genres.genre_id = programs.genre_id
INNER JOIN channels ON programs.channel_id = channels.channel_id
INNER JOIN series ON programs.program_id = series.program_id
INNER JOIN seasons ON series.series_id = seasons.series_id
INNER JOIN episodes ON seasons.season_id = episodes.season_id
GROUP BY genre_name, programs.program_name
ORDER BY AVG(episodes.view_number) DESC;
```

- 出力結果：
+------------+----------------------+----------------------+
| ジャンル名 | 番組タイトル         | エピソード平均視聴数 |
+------------+----------------------+----------------------+
| ドラマ     | 半沢直樹             |         3680000.0000 |
| ドラマ     | 大河ドラマ           |          547500.0000 |
| アニメ     | 鬼滅の刃             |          440000.0000 |
| アニメ     | ドラゴンボールZ      |          403000.0000 |
| ニュース   | おはよう日本         |          172000.0000 |
| アニメ     | ワンピース           |          153000.0000 |
| アニメ     | 進撃の巨人           |           83333.3333 |
| ドラマ     | コンフィデンスマンJP |           82500.0000 |
| ドラマ     | 相棒                 |           64500.0000 |
| アニメ     | ブラッククローバー   |           20030.0000 |
+------------+----------------------+----------------------+



