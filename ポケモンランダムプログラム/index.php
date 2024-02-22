<?php

// $imgs = [
//     "ポケモンimg/001フシギダネ.png",
//     "ポケモンimg/002フシギソウ.png",
//     "ポケモンimg/003フシギバナ.png",
//     "ポケモンimg/004ヒトカゲ.png",
//     "ポケモンimg/005リザード.png",
//     "ポケモンimg/006リザードン.png",
// ];

// $img_rand = $imgs[mt_rand(0, count($imgs) -1)];

// echo '<img src= "' .$img_rand. '" alt="">'; 

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>ポケモンランダムプログラム！</h1>
    <p>今日のポケモンは？</p>
    <div id="target"></div>
    <input type="button" value="君に決めた！" id="bt">

    <script language="javascript" type="text/javascript">
        const target = document.getElementById('target');
        const bt = document.getElementById('bt');
        const imglist = [
            "ポケモンimg/001フシギダネ.png",
            "ポケモンimg/002フシギソウ.png",
            "ポケモンimg/003フシギバナ.png",
            "ポケモンimg/004ヒトカゲ.png",
            "ポケモンimg/005リザード.png",
            "ポケモンimg/006リザードン.png",
            "ポケモンimg/007ゼニガメ.png",
            "ポケモンimg/008カメール.png",
            "ポケモンimg/009カメックス.png",
            "ポケモンimg/010キャタピー.png",
            "ポケモンimg/011トランセル.png",
            "ポケモンimg/012バタフリー.png",
            "ポケモンimg/013ビードル.png",
            "ポケモンimg/014コクーン.png",
            "ポケモンimg/015スピアー.png",
            "ポケモンimg/016ポッポ.png",
            "ポケモンimg/017ピジョン.png",
            "ポケモンimg/018ピジョット.png",
            "ポケモンimg/019コラッタ.png",
            "ポケモンimg/020ラッタ.png",
            "ポケモンimg/021オニスズメ.png",
            "ポケモンimg/022オニドリル.png",
            "ポケモンimg/023アーボ.png",
            "ポケモンimg/024アーボック.png",
            "ポケモンimg/025ピカチュウ.png",
            "ポケモンimg/026ライチュウ.png",
            "ポケモンimg/027サンド.png",
            "ポケモンimg/028サンドパン.png",
            "ポケモンimg/029ニドラン♀.png",
            "ポケモンimg/030ニドリーナ.png",
            "ポケモンimg/031ニドクイン.png",
            "ポケモンimg/032ニドラン♂.png",
            "ポケモンimg/033ニドリーノ.png",
            "ポケモンimg/034ニドキング.png",
            "ポケモンimg/035ピッピ.png",
            "ポケモンimg/036ピクシー.png",
            "ポケモンimg/037ロコン.png",
            "ポケモンimg/038キュウコン.png",
            "ポケモンimg/039プリン.png",
            "ポケモンimg/040プクリン.png",
            "ポケモンimg/041ズバット.png",
            "ポケモンimg/042ゴルバット.png",
            "ポケモンimg/043ナゾノクサ.png",
            "ポケモンimg/044クサイハナ.png",
            "ポケモンimg/045ラフレシア.png",
            "ポケモンimg/046パラス.png",
            "ポケモンimg/047パラセクト.png",
            "ポケモンimg/048コンパン.png",
            "ポケモンimg/049モルフォン.png",
            "ポケモンimg/050ディグダ.png",
            "ポケモンimg/051ダグトリオ.png",
            "ポケモンimg/052ニャース.png",
            "ポケモンimg/053ペルシアン.png",
            "ポケモンimg/054コダック.png",
            "ポケモンimg/055ゴルダック.png",
            "ポケモンimg/056マンキー.png",
            "ポケモンimg/057オコリザル.png",
            "ポケモンimg/058ガーディ.png",
            "ポケモンimg/059ウインディ.png",
            "ポケモンimg/060ニョロモ.png",
            "ポケモンimg/061ニョロゾ.png",
            "ポケモンimg/062ニョロボン.png",
            "ポケモンimg/063ケーシィ.png",
            "ポケモンimg/064ユンゲラー.png",
            "ポケモンimg/065フーディン.png",
            "ポケモンimg/066ワンリキー.png",
            "ポケモンimg/067ゴーリキー.png",
            "ポケモンimg/068カイリキ―.png",
            "ポケモンimg/069マダツボミ.png",
            "ポケモンimg/070ウツドン.png",
            "ポケモンimg/071ウツボット.png",
            "ポケモンimg/072メノクラゲ.png",
            "ポケモンimg/073ドククラゲ.png",
            "ポケモンimg/074イシツブテ.png",
            "ポケモンimg/075ゴローン.png",
            "ポケモンimg/076ゴローニャ.png",
            "ポケモンimg/077ポニータ.png",
            "ポケモンimg/078ギャロップ.png",
            "ポケモンimg/079ヤドン.png",
            "ポケモンimg/080ヤドラン.png",
            "ポケモンimg/081コイル.png",
            "ポケモンimg/082レアコイル.png",
            "ポケモンimg/083カモネギ.png",
            "ポケモンimg/084ドードー.png",
            "ポケモンimg/085ドードリオ.png",
            "ポケモンimg/086パウワウ.png",
            "ポケモンimg/087ジュゴン.png",
            "ポケモンimg/088ベトベター.png",
            "ポケモンimg/089ベトベトン.png",
            "ポケモンimg/090シェルダー.png",
            "ポケモンimg/091パルシェン.png",
            "ポケモンimg/092ゴース.png",
            "ポケモンimg/093ゴースト.png",
            "ポケモンimg/094ゲンガー.png",
            "ポケモンimg/095イワーク.png",
            "ポケモンimg/096スリープ.png",
            "ポケモンimg/097スリーパー.png",
            "ポケモンimg/098クラブ.png",
            "ポケモンimg/099キングラー.png",
            "ポケモンimg/100ビリリダマ.png",
            "ポケモンimg/101マルマイン.png",
            "ポケモンimg/102タマタマ.png",
            "ポケモンimg/103ナッシー.png",
            "ポケモンimg/104カラカラ.png",
            "ポケモンimg/105ガラガラ.png",
            "ポケモンimg/106サワムラー.png",
            "ポケモンimg/107エビワラー.png",
            "ポケモンimg/108ベロリンガ.png",
            "ポケモンimg/109ドガース.png",
            "ポケモンimg/110マタドガス.png",
            "ポケモンimg/111サイホーン.png",
            "ポケモンimg/112サイドン.png",
            "ポケモンimg/113ラッキー.png",
            "ポケモンimg/114モンジャラ.png",
            "ポケモンimg/115ガルーラ.png",
            "ポケモンimg/116タッシー.png",
            "ポケモンimg/117シードラ.png",
            "ポケモンimg/118トサキント.png",
            "ポケモンimg/119アズマオウ.png",
            "ポケモンimg/120ヒトデマン.png",
            "ポケモンimg/121スターミー.png",
            "ポケモンimg/122バリヤード.png",
            "ポケモンimg/123ストライク.png",
            "ポケモンimg/124ルージュラ.png",
            "ポケモンimg/125エレブー.png",
            "ポケモンimg/126ブーバー.png",
            "ポケモンimg/127カイロス.png",
            "ポケモンimg/128ケンタロス.png",
            "ポケモンimg/129コイキング.png",
            "ポケモンimg/130ギャラドス.png",
            "ポケモンimg/131ラプラス.png",
            "ポケモンimg/132メタモン.png",
            "ポケモンimg/133イーブイ.png",
            "ポケモンimg/134シャワーズ.png",
            "ポケモンimg/135サンダース.png",
            "ポケモンimg/136ブースター.png",
            "ポケモンimg/137ポリゴン.png",
            "ポケモンimg/138オムナイト.png",
            "ポケモンimg/139オムスター.png",
            "ポケモンimg/140カブト.png",
            "ポケモンimg/141カブトプス.png",
            "ポケモンimg/142プテラ.png",
            "ポケモンimg/143カビゴン.png",
            "ポケモンimg/144フリーザー.png",
            "ポケモンimg/145サンダー.png",
            "ポケモンimg/146ファイヤー.png",
            "ポケモンimg/147ミニリュウ.png",
            "ポケモンimg/148ハクリュー.png",
            "ポケモンimg/149カイリュー.png",
            "ポケモンimg/150ミュウツー.png",
            "ポケモンimg/151ミュウ.png"
        ];

        bt.addEventListener('click', function() {
            const tempImgList = [...imglist]; // 元の画像リストからコピーを作成
            const selectedImages = [];

            while (selectedImages.length < 6 && tempImgList.length > 0) {
                const selectnum = Math.floor(Math.random() * tempImgList.length);
                selectedImages.push(tempImgList.splice(selectnum, 1)[0]); // 重複しないように選択
            }

            const imageElements = selectedImages.map(img => '<img src="' + img + '" alt="" />').join('');
            target.innerHTML = imageElements;
        });

    </script>

</body>
</html>