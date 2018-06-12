<?php
/**
 * Created by PhpStorm.
 * User: troub
 * Date: 2017/3/15
 * Time: 22:55
 */
#use Workerman\Worker;
require 'vendor/autoload.php';
#require_once __DIR__ . '/Workerman/Autoloader.php';
#require_once __DIR__.'/mysql/src/Connection.php';

$ip = '127.0.0.1';
$chengyu1=array(            //存储成语的数组
    '字面意思是只要吩咐便听从。形容对某个人的绝对服从，不敢有半点违抗。',
    '字面意思是因理亏而说不出一个词来应对。',
    '字面意思是好像坐在插着针的毯子上；形容心神不定，坐立不安。',
    '字面意思是把竹子用完了都写不完，多形容罪恶很多，难以说完。',
    '字面意思是拉一下袖子就就能看见胳膊肘，形容衣服破烂。比喻顾此失彼，穷于应付。',
    '这是一个跟三国时期，吴国的一名将领有关的成语。常用来指缺少才干，学识尚浅的人，现多用于他人有了转变，学识大进，或者地位攀高。',
    '字面意思是依仗某种条件顽固抵抗。',
    '字面意思是形势就像劈竹子一样，比喻作战或工作节节胜利，毫无阻碍。',
    '字面意思是平稳地登上青天白地位置，指人一下子轻易登上很高的官位。',
    '字面意思是他送给我一种水果，我就回赠他另一种水果。 比喻友好往来或互相赠送东西。',
    '字面意思是酒杯和酒筹杂乱的摆在桌面上。形容许多人聚会喝酒时的热闹场景。',
    '很简单，意思就是话说不到一起去，没办法愉快的聊天儿。',

    '《诗经·邶风·击鼓》中写道：死生契（qie）阔，与子成说请说出下面两句。',
    '请根据大屏幕上的词回答出纳兰性德所做的这首词所对应的词牌名<br>
    飞絮飞花何处是，层冰积雪摧残。疏疏一树五更寒，爱他明月好，憔悴也相关。<br>
    最是繁丝摇落后，转教人忆春山，湔（jian）裙梦断续应难，西风多少恨，吹不散眉弯。',
    '唐代著名诗人杜牧曾在自己的诗《金谷园》中写道“繁华事散逐香尘，流水无情草自春。日暮东风怨啼鸟，落花犹似坠楼人。”请问诗中的“坠楼人”指的是谁？',
    '《问刘十九》白居易“晚来天欲雪”，请接下句。',
    '红楼梦中黛玉做了五首绝句，分别描写了中国古代五位女子，并合称为《五美吟》其中有一首中写道“黥（qing）彭甘受他年醢，饮剑何如楚帐中。”，请问这首诗描写了哪位女子？',
    '歌手李行亮曾经唱过一首歌并把这首歌取名为“愿得一人心”。实际上名字取自于诗词《白头吟》，那么请问诗词《白头吟》的作者是当垆卖酒的（        ）请说出作者名字。',
    '《寄人》张泌（bi）“多情只有春庭月”请接下句。',
    '位于绍兴的沈园是宋代著名园林，在这里发生了一场凄美的重逢，男主人公赠了女主人公一首《钗头凤》，女主人公亦回赠一首，来表示对于往事的怀念。后世评价这两首《钗头凤》“就百年论，谁愿有此事？就千秋论，不可无此诗。”请问如此才华横溢的男主人公和女主人公分别是谁呢？',
    '唐代诗人温庭筠在自己的诗里写了“井底点灯深烛伊，共郎长行莫围棋。玲珑骰子安红豆，入骨相思知不知。”四句来表达相思之情，其实这种以红豆寄托相思的表达方式在王维的诗词《相思》（红豆生南国，春来发几枝）中早就出现过，请背诵《相思》中后两句。',
    '《破阵子》李煜“最是仓皇辞庙日，教坊犹奏别离歌，”请接下句。',
    '孟郊在什么情况下写下了“昔日龌龊不足夸，今朝放荡思无涯。春风得意马蹄疾，一日看尽长安花。”这首诗？',
    '辛弃疾《青玉案》中“东风夜放花千树”中的“花千树”指的是什么？',

    '下列词语中有错别字的一项是（  ）<br>A. 俯首帖耳 拍案叫绝 锐不可挡<br>B. 人声鼎沸 稍纵即逝 销声匿迹<br>C. 不毛之地 天经地义 与日俱增<br>D. 深恶痛疾 姹紫嫣红 不屑置辩',
    '下面红字注音正确的一项是（   ）
<br>A. 暴<red>殄</red>天物(tian三声)
<br>B. <red>咋</red>舌(za三声)
<br>C. <red>恽</red>代英(hui一声)
<br>D. <red>郫</red>县(pi三声)
',
    '以下红字读音不相同的一组是（  ）
<br>A. <red>苍</red>天 <red>创</red>造  <red>疮</red>痍  踉<red>跄</red>
<br>B. <red>斫</red>痕  洗<red>濯</red>  商<red>酌</red>  烧<red>灼</red>
<br>C. <red>拮</red>据  <red>诘</red>责  <red>劫</red>难  <red>碣</red>石
<br>D. 茶<red>几</red>  滑<red>稽</red>  <red>羁</red>绊  <red>畸</red>形  
',
    '以下红字声调不相同的一组是（   ）
<br>A. 蝉<red>蜕</red>  <red>兑</red>现 <red>脱</red>离  喜<red>悦</red>
<br>B. <red>炽</red>热  <red>翅</red>膀  充<red>斥</red>  <red>叱</red>咤
<br>C. 小<red>憩</red>  哭<red>泣</red>  放<red>弃</red>  <red>契</red>约
<br>D. <red>遒</red>劲  <red>虬</red>须  <red>泅</red>水  <red>裘</red>皮
',
    '下列注音完全正确的一组是（   ）
<br>A. 囿于成见(you四声 yú chéng jiàn)
<br>B. 跋扈(bá huo四声)
<br>C. 壅塞(yōng sai一声)
<br>D. 日冕(rì gui三声)
',
    '春hui（一声）（   ）
<br>A. 晖
<br>B. 辉
<br>C. 珲
',
    ' wei编三绝（   ）
    <br>A. 韦
    <br>B. 苇
    <br>C. 纬
    ',
    '河清海yan（四声）（  ）
<br>A. 晏
<br>B. 沇
<br>C. 漹
<br>D. 溎
',
    '下列词语中，没有错别字的一项是
<br>A. 派遣    浑然天成     家喻户晓     前事不忘，后世之师
<br>B. 安详    变幻莫测     与日俱增     心有灵犀一点通
<br>C. 迁徙    目不识丁     获益匪浅     一年之际在于春
<br>D. 惩诫    得天独厚     忧心忡忡     有福同享，有难同当
',
    '下列句子中加字及字的注音都正确的一项是（   ）
<br>A. 我这张笨拙(zhuó)的嘴，想到的也说不出。
<br>B. 他一手拿着布，一手攥(zhuàn)着钱，滞笨地转过身子。
<br>C. 他勉强(qiǎng)地从座位上站起来。
<br>D. 我们应该本着“承(chéng)前毖后，治病救人”的态度开展批评与自我批评。
',
    '下列词语书写全部正确的一项是（   ）
<br>A. 夜宵    坚苦卓绝    鸦雀无声
<br>B. 肆虐    风糜一时    出类拔萃
<br>C. 安排    枯躁乏味    病入膏肓
<br>D. 脉搏    世外桃源    应接不瑕
',
    ' 下列词语中红字的读音，全都不相同的一项是（   ）
<br>A. 笨<red>拙</red> <red>茁</red>壮 罢<red>黜</red> <red>咄</red>咄逼人
<br>B. <red>恬</red>静 <red>聒</red>噪 <red>甜</red>蜜 <red>舔</red>犊情深
<br>C. 踉<red>跄</red> <red>创</red>伤 悲<red>怆</red> 满目<red>疮</red>痍
<br>D. <red>炫</red>耀 琴<red>弦</red> 船<red>舷</red> 头晕目<red>眩</red>
',

    '这个成语指的是古代官吏以年老多病为理由向皇帝请求辞去官职，回到家乡。',
    '意思是老虎离开深山，落到了平地里受困。比喻有权有势者或有实力者失去了自己的权势或优势。',
    '字面意思是人们的流言蜚语是很可怕的。',
    '很熟悉的朋友因为一些事情，不在交往或联系，再次相见却像陌生的路人一样。',
    '字面意思是悬于半空之中的城市楼台，现多用来比喻虚构的事物或不现实的理论、方案等。',
    '字面意思是外有强形，内中干竭。泛指外表强大，内实空虚。',
    '字面意思是第一个用俑封杀活人的人，后泛指恶劣风气的创始者。',
    '字面意思是形容没有腿却能跑，多指消息无声地传播。',
    '字面意思是千万匹马都沉寂无声，多用来比喻人们都沉默，不说话，不发表意见，形容局面沉闷。',
    '字面意思是兵器为枕，以待天明。多指时刻警惕，准备作战，连睡觉时也不放松戒备，随时准备着杀敌。形容杀敌报国心切。',
    '意思是当错误的思想和行为刚有苗头或征兆时，就加以预防与制止，坚决不让它继续发展。',
    '字面意思是彼此一向不了解，与某人从来不认识。在这里给出这个成语的示例“在其在前曰：真为～，突如其来，难怪妾之得罪。”出自 元·王实甫《西厢记》第二本第三折',

    '我们都知道《无题》诗的代表人物为李商隐，那么请问以下哪句诗词不是李商隐所做的《无题》诗？
        <br>A.	春蚕到死丝方尽，蜡炬成灰泪始干。
        <br>B. 身无彩凤双飞翼，心有灵犀一点通。
        <br>C. 秋阴不散霜飞晚，留得枯荷听雨声。
        <br>D. 刘郎已恨蓬山远，更隔蓬山一万重。
',
    '《秋风词·三五七言》李白“早知如此绊人心”请接下句。',
    '请根据大屏幕上的词回答出贺铸所做的这首词所对应的词牌名<br>
        凌波不过横塘路，但目送，芳尘去，锦瑟华年谁与度？月桥花院，琐（suo）窗朱户，只有春知处。<br>
        碧云冉冉蘅（heng）皋（gao）暮，彩笔新题断肠句。试问闲情都几许？一川烟草，满城风絮，梅子黄时雨。
',
    '秦淮八艳之一的柳如是原名柳隐，号如是。请问她因为辛弃疾《贺新郎》中的哪几句而自号“如是”？',
    '《临安春雨初霁》陆游“素衣莫起风尘叹”请接下句',
    '在我国诗词史上有一朵奇葩，这位文学家据传是上古高阳氏的子孙，他曾说要“朝饮木兰之坠露，夕餐秋菊之落英”，也曾想要让蛟龙来帮他开路，凤皇帮他扛旗。请问这位想象奇绝的文学家是谁？',
    '郑思肖曾在自己的代表作中写道“花开不并百花丛，独立疏篱趣未穷。宁可枝头抱香死，何曾吹落北风中？”请问这首诗描写的是什么？',
    '唐代诗人李白在唐朝可谓名倾一时，杜甫评价他“白也诗无敌”，白居易评价他“曾有惊天动地文”，唐伯虎评价他“我愧虽无李白才”然而像李白这样优秀的诗人也有自己敬佩景仰的人。李白曾在自己的诗中评价他说“红颜弃轩冕，白首卧松云。醉月频中圣，迷花不事君。高山安可仰，徒此挹清芬。”请问这个让大诗人李白都感到敬佩的诗人他是谁呢？',
    '辛弃疾的《清平乐·村居》（茅檐低小）中主人公有几个儿子？ 
    <br>A.1个
    <br>B.词中没提到他有儿子
    <br>C.2个
    <br>D.3个
',
    '请选出下列有错误的一项
<br>A. 王昌龄-------被称为“七绝圣手”--------写过“洛阳亲友如相问，一片冰心在玉壶。”
<br>B. 李清照-------字易安--------写过“兴尽晚回舟，误入藕花深处。”
<br>C. 贺铸-------宋代词人--------写过“当年不肯嫁春风，无端却被秋风误。”
<br>D. 柳永------歌女妓女为其举办吊柳会------写过“忍把浮名，换了浅斟低唱！”
',
    '唐朝是诗歌的代表时期之一，唐朝诗人如过江之鲫，多不胜数，据传在唐朝290年间竟然出现了207位女诗人，其中有四位女诗人被并称为“唐代四大女诗人”，请任意说出其中的三位。',
    '《红楼梦》第四十九回中，宝钗笑香菱道：“满嘴里说的是什么：怎么是‘杜工部之沉郁，韦苏州之淡雅，温八叉之绮靡，李义山之隐僻。’放着两个现成的诗家不知道，提那些死人做什么！”，请问宝钗口中的“杜工部”，“韦苏州”，“温八叉”，“李义山”分别是哪四位诗人？',

    '1. 下列词语中红字读音不完全相同的一项是（  ）
<br>A. <red>定</red>单 <red>钉</red>死 <red>锭</red>子 <red>盯</red>梢
<br>B. 休<red>憩</red> <red>迄</red>今 <red>器</red>材 哭<red>泣</red>
<br>C. <red>谛</red>听 <red>缔</red>造 <red>帝</red>王 <red>递</red>增 
<br>D. <red>义</red>务 游<red>弋</red> <red>艺</red>术 <red>议</red>会
',
    '下面红字注音正确的一项是（  ）
<br>A. <red>猝</red>然(cù)　<red>镂</red>空(lòu)　<red>拈</red>轻怕重(zhān)
<br>B. <red>蜕</red>变(tuì)　<red>畸</red>形(ji一声)　沁人心<red>脾</red>(pi二声)
<br>C. <red>酝</red>酿(yùn)　<red>绽</red>放(zhàn)　忍俊不<red>禁</red>(jin四声) 
<br>D. 修<red>葺</red>(qì)　<red>窥</red>视(kuī)　<red>杞</red>人忧天(jǐ)
',
    '下面红字注音正确的一项是（   ）
<br>A. <red>间</red>歇(jian四声)
<br>B. 颠<red>茄</red>(jia一声)
<br>C. 熨<red>帖</red>(tie四声)
<br>D. 图<red>们</red>江(men轻声)
',
    '下列注音完全正确的一组是（   ）
<br>A. 襁褓(qiang三声 bǎo)
<br>B. 三聚氰胺(sān jù qíng an一声)
<br>C. 癞蛤蟆(lài há mo轻声)
<br>D. 拾掇(shí duo一声)
',
    '下列注音完全正确的一组是（   ）
<br>A. 驽马(nu二声 mǎ )
<br>B. 兄弟阋墙(xiōng dì ni四声 qiáng)
<br>C. 汗水涔涔(hàn shuǐ cen二声 cen二声)
<br>D. 荦荦大端(qiong二声 qiong二声 dà duān)
',
    '下列注音完全正确的一组是（   ）
<br>A. 方兴未艾(fāng xīng wèi ai四声)
<br>B. 火铳(huǒ tong三声)
<br>C. 反刍(fǎn zou一声) 
<br>D. 怄气(ou一声 qì)
',
    '下列注音完全正确的一组是（   ）
<br>A. 毕肖(bì xiao四声)
<br>B. 揉搓(róu cuo轻声)
<br>C. 尔虞我诈(ěr yu三声 wǒ zhà)
<br>D. 择菜(zhai一声 cài)
',
    '下列注音完全正确的一组是（   ）
<br>A. 皴裂(jun一声 liè)
<br>B. 扑尔敏(pu三声 ěr mǐn)
<br>C. 造诣(zào zhi三声)
<br>D. 颐指气使(yi二声 zhǐ qì shǐ)
',
    '以下声调相同的一组是（   ）
<br>A. 矩、锯、毓
<br>B. 俚、媪、鸨
<br>C. 旒、蹯、菡
<br>D. 耶、佻、坳
',
    '下列词语的音、形和对加点字字义的解释全都正确的一项是（   ）
<br>A. 贮（zhù）藏    痉挛    希冀（希望）
<br>B. 剽（piāo）悍    瞬息   热忱（真实的情意）
<br>C. 旌（jīn）旗      惋惜    迁徙（调动）
<br>D. 怪癖（pì）       舆论    肆虐（残暴）
',
    '列注音完全正确的一组是（   ）
<br>A. 翘楚(qiao二声 chǔ)
<br>B. 滂沱(pang二声 tuó)
<br>C. 暮霭(mù ai二声 )
<br>D. 摒除(bing三声 chú)
',
    '下列注音完全正确的一组是（   ）
<br>A. 轮毂(lún gu三声)
<br>B. 杀手锏(shā shǒu jian一声)
<br>C. 鼹鼠(yan四声 shǔ)
<br>D. 鳜鱼(jue二声 yú)
',

    '“鸟尽弓藏”是说古代一些成功人士事情成功之后，就把曾经的功臣废黜罢免。请问这个成语最初讲述的是谁的故事？
<br>A.勾践和范蠡B.刘邦和韩信C.赵匡胤和曹彬
',
    '“投鼠忌器”的意思是家里进了老鼠，想用东西砸死老鼠又怕砸坏老鼠附近的用具。请问这句话的出处来自于以下哪两个人之间的对话？
<br>A.刘备和关羽B.项羽和范增C.嬴政和王翦
',
    '“韦编三绝”的意思是编书简用的绳子都断了三次，比喻读书勤奋。请问这个成语最初指的是谁读书勤奋？
    <br>A.颜渊B.孔子C.孟子',
    '“不求甚解”的意思是读书只求知道个大概，不求彻底了解。请问这个成语最早说的是谁读书不求甚解？
<br>A.范仲淹B.欧阳修 C.陶渊明
',
    '“指鹿为马”是用来形容一些人故意颠倒黑白，混淆是非。请问，这个成语最初讲的是下列哪个人指着鹿却非说是马？
<br>A.董卓B.赵高C.曹操
',
    '“破釜沉舟”形容的是做一件事情下定决心，义无反顾。请问这个成语最初说的是下列哪位人物大战之前砸锅又沉船？
<br>A.汉高祖刘邦 B.西楚霸王项羽 C.淮阴侯韩信
',
    '请问“一家之言”是谁的文学观点？
<br>A.司马迁B.欧阳修C.曹操
',
    '“东窗事发”是用来比喻坏蛋的阴谋已败露。请问这个成语最初讲的是以下哪位奸臣的阴谋败露了？
<br>A.董卓B.秦桧C.和珅
',
    '“才占八斗”多用来形容古代的大才子学问高超，诗才敏捷。请问这句话最初是用来评价哪位才子的？
<br>A.苏轼B.李白C.曹植
',
    '“暗度陈仓”是楚汉争霸时期刘邦集团的一次著名军事行动。请问是谁装作要从栈道进攻关中，却带领主力部队袭击了陈仓，进而攻人咸阳？
<br>A.萧何B.韩信 C.张良
',
    '“洛阳纸贵”最早形容的是谁的文学作品盛极一时？
<br>A.班固B.左思C.班超
',
    '“一字千金”最早指的是谁的举动
<br>A.吕不韦 B,范睢 C.白起
',

    '宋朝著名诗人，词人，文学家苏轼曾经在自己的一首《西江月》中如是写道“素面倒嫌粉涴（wo），洗妆不褪唇红。高情已逐晓云空，不与梨花同梦。”请问这首词描写的是什么花？',
    '琼瑶阿姨曾经写过一本小说名字叫做《一帘幽梦》，实际上这本小说的名字引用自秦少游的一首《八六子》，请问具体引用自这首词中的哪两句话呢？',
    '《绮怀》黄景仁“似此星辰非昨夜”请接下句',
    '苏轼《定风波》中“万里归来颜愈少，微笑，笑时犹带岭梅香。试问，‘岭南应不好？’，却道”请接下句',
    '朱庆馀在《闺意献张水部》一诗中曾写道“洞房昨夜停红烛，待晓堂前拜舅姑。妆罢低声问夫婿，画眉深浅入时无。”意思是问自己答的卷子还和不和张籍的心意，张籍看到诗后认为他卷子写得非常好，同时也给他回了一首诗。请用张籍原诗说明张籍是怎么夸奖他的（背诵一至两句即可）',
    '《长门怨》李白“月光欲到长门殿”请接下句',
    '请根据大屏幕上的词回答出辛弃疾所做的这首词所对应的词牌名<br>
更能消、几番风雨，匆匆春又归去。惜春长怕花开早，何况落红无数。春且住。见说道、天涯芳草无归路。怨春不语。算只有殷勤、画檐蛛网，近日惹飞絮。<br>
长门事，准拟佳期又误，蛾眉曾有人妒。千金纵买相如赋，脉脉此情难诉？君莫舞。君不见、玉环飞燕皆尘土！闲愁最苦。休去倚危栏，斜阳正在，烟柳断肠处。
',
    '宋代词人晏几道曾经写过一首《临江仙》<br>
梦后楼台高锁，酒醒帘幕低垂。去年春恨却来时，落花人独立，微雨燕双飞。<br>
记得小蘋初见，两重心字罗衣。琵琶弦上说相思，当时明月在，曾照彩云归。<br>
词中“落花人独立，微雨燕双飞。”为流传千古的好句子，但实际上这两句词是他引用的前人古诗，请问引用的是唐代诗人翁宏的哪一首诗？
',
    '《鹧鸪天》晏几道“蒙混惯得无拘检”请接下句',
    '请问杨万里诗中“坐看深来尺许强，偏於薄暮发寒光。半空舞倦居然懒，一点风来特地忙。”描写的是什么？',
    '李商隐诗中“唯有绿荷红菡萏，卷舒开合任天真。”诗中的“菡萏”所指的是什么？',
    '《浣溪沙》纳兰性德“但是有情皆满愿，更从何处著思量”请接下句',
);
$answer1 = array(
    '唯命是从',
    '理屈词穷',
    '如坐针毡',
    '罄竹难书',
    '捉襟见肘',
    '吴下阿蒙',
    '负隅顽抗',
    '势如破竹',
    '平步青云',
    '投桃报李',
    '觥筹交错',
    '话不投机',
    '执子之手，与子偕老',
    '临江仙',
    '绿珠',
    '能饮一杯无',
    '虞姬',
    '卓文君',
    '犹为离人照落花',
    '陆游，唐婉',
    '愿君多采撷，此物最相思',
    '垂泪对宫娥',
    '登科后（或者进士及第后）',
    '灯',
    'A',
    'A',
    'A',
    'A',
    'A',
    'A',
    'A',
    'A',
    'B',
    'C',
    'A',
    'A',
    '告老还乡',
    '虎落平阳',
    '人言可畏',
    '形同陌路',
    '空中楼阁',
    '外强中干',
    '始作俑者',
    '不胫而走',
    '万马齐喑',
    '枕戈待旦',
    '防微杜渐',
    '素昧平生',
    'C',
    '还如当日不相识',
    '青玉案',
    '我见青山多妩媚，料青山见我应如是（只回答后面一句也可以）',
    '犹及清明可到家',
    '屈原',
    '菊花',
    '孟浩然',
    'D',
    'B',
    '鱼玄机（或者鱼幼薇，鱼蕙兰）<br>李冶（或者李季兰）<br>薛涛（或者薛洪度）<br>刘采春',
    '杜甫，韦应物，温庭筠，李商隐',
    'A',
    'B',
    'A',
    'A',
    'C',
    'A',
    'A',
    'D',
    'B',
    'A',
    'A',
    'A',

    'A',
    'A',
    'B',
    'C',
    'B',
    'B',
    'A',
    'B',
    'C',
    'B',
    'B',
    'A',

    '梅花',
    '夜月一帘幽梦，春风十里柔情',
    '为谁风露立中宵',
    '此心安处是吾乡',
    '越女新妆出镜心，自知明艳更沉吟。<br>齐纨未足时人贵，一曲菱歌敌万金。',
    '别作深宫一段愁',
    '摸鱼儿',
    '春残',
    '又踏杨花过谢桥',
    '雪',
    '荷花（莲花，藕花，芙蕖）',
    '篆烟残烛并回肠',
    );
$chengyu2=array(
    "一身是胆",
    "张牙舞爪",
    "愁眉苦脸",
    "狼吞虎咽",
    "金鸡独立",
    "眉飞色舞",
    "自言自语",
    "小鸟依人",
    "挤眉弄眼",
    "掩耳盗铃",
    "坐井观天",
    "井底之蛙",
    "闻鸡起舞",
    "咬牙切齿",
    "步履蹒跚",
    "东倒西歪",
    "抓耳挠腮",
    "破涕为笑",
    "狐假虎威",
    "画蛇添足",
    "声东击西",
    "三足鼎立",
    "围魏救赵",
    "唇亡齿寒",
    "三心二意",
    "生龙活虎",
    "画龙点睛",
    "叶公好龙",
    "龙凤呈祥",
    "鹏程万里",
    "万马奔腾",
    "心想事成",
    "六面玲珑",
    "万紫千红",
    "迎风招展",
    "闭目养神",
    "隔靴搔痒",
    "垂头丧气",
    "上蹿下跳",
    "顺手牵羊",
    "亡羊补牢",
    "揠苗助长",
    "目瞪口呆",
    "三人成虎",
    "盲人摸象",
    "摇头摆尾",
    "一箭双雕",
    "左顾右盼",
    "顾盼生姿",
    "手舞足蹈",
    "捧腹大笑",
    "鹤立鸡群",
    "怒目而视",
    "瞠目结舌",
    "螳臂当车",
    "一叶知秋",
    "如鱼得水",
    "暴跳如雷",
    "上下其手",
    "画饼充饥",
    "打草惊蛇",
    "囫囵吞枣",
    "一心一意",
    "惊弓之鸟",
    "对牛弹琴",
    "走马观花",
    "花拳绣腿",
    "哭笑不得",
    "捶胸顿足",
    "九牛二毛",
    "连蹦带跳",
    "马到成功",
    "喜出望外",
    "喜极而泣",
    "一网打尽",
    "窃窃私语",
    "纸上谈兵",
    "海枯石烂",
    "滥竽充数",
    "望梅止渴",
    "废寝忘食",
    "管中窥豹",
    "斩草除根",
    "南辕北辙",
    "唇亡齿寒",
    "七上八下",
    "玩火自焚",
    "翩翩起舞",
    "转悲为喜",
    "愚公移山",
    "杞人忧天",
    "一马当先",
    "刻舟求剑",
    "不屈不挠",
    "喜上眉梢",
    "门可罗雀",
    "朝三暮四",
    "如鱼得水",
    "大鹏展翅",
    "完璧归赵",
    "草船借箭",
    "班门弄斧",
    "拳打脚踢",
    "走马观花",
    "一丝不苟",
    "不闻不问",
    "天方夜谭",
    "阿谀奉承",
    "吉祥如意",
    "翻天覆地",
    "羊入虎口",
    "无与伦比",
    "四面八方",
    "白纸黑字",
    "四大皆空",
    "德高望重",
    "比翼双飞",
    "正中下怀",
    "人仰马翻",
    "开膛破肚",
    "身怀六甲",
    "笑里藏刀",
    "乌合之众",
    "明争暗斗",
    "心腹大患",
    "一手遮天",
    "无中生有",
    "事半功倍",
    "粗茶淡饭",
    "水滴石穿",
    "远走高飞",
    "病从口入",
    "楚汉河界",
    "东山再起",
    "一衣带水",
    "闭门思过",
    "才高八斗",
    "破口大骂",
    "甘拜下风",
    "口蜜腹剑",
    "汗流浃背",
    "对牛弹琴",
    "九牛二虎",
    "粗中有细",
    "两面三刀",
    "异曲同工",
    "口是心非",
    "心直口快",
    "一刀两断",
    "三长两短",
    "一五一十",
    "十面埋伏",
    "里应外合",
    "多此一举",
    "四脚朝天",
    "飞蛾扑火",
    "气吞山河",
    "见钱眼开",
    "排山倒海",
    "雪上加霜",
    "虎头蛇尾",
    "心腹大患",
    "锦上添花",
    "釜底抽薪",
    "行尸走肉",
    "祸从口出",
    "三从四德",
    "满面红光",
    "一落千丈",
    "仗势欺人",
    "风雨同舟",
    "官官相护",
    "狗尾续貂",
    "缺衣少食",
    "自圆其说",
    "旗开得胜",
    "一叶障目",
    "卧薪尝胆",
    "接二连三",
    "势如破竹",
    "普天同庆",
    "弱不禁风",
    "吃里扒外",
    "不堪入目",
    "大材小用",
    "五光十色",
    "夸父追日",
    "呆若木鸡",
    "凤毛麟角",
    "鬼哭狼嚎",
    "节外生枝",
    "开门见山",
    "双管齐下",
    "崇山峻岭",
    "血口喷人",
    "兵临城下",
    "泰山压顶",
    "杀鸡取卵",
    "以卵击石",
    "乘风破浪",
    "黑白分明",
    "高高在上",
    "杯弓蛇影",
    "石破天惊",
    "鸡同鸭讲",
    "鸦雀无声",
    "先礼后兵",
    "礼让三先",
    "貌合神离",
    "一塌糊涂",
    "能屈能伸",
    "举一反三",
    "倾国倾城",
    "阴差阳错",
    "水到渠成",
    "劳燕分飞",
    "相濡以沫",
    "只手遮天",
    "衣食父母",
    "悬崖勒马",
    "两厢情愿",
    "步步为营",
    "请君入瓮",
    "人满为患",
    "入木三分",
    "啼笑皆非",
    "是是而非",
    "左右开弓",
    "风花雪月",
    "可圈可点",
    "三姑六婆",
    "半壁江山",
    "茅塞顿开",
    "乘人不备",
    "火冒三丈",
    "本末倒置",
    "东拼西凑",
    "有生之年",
    "归心似箭",
    "军令如山",
    "轻于鸿毛",
    "无穷无线",
    "一泻千里",
    "四通八达",
    "身首异处",
    "木已成舟",
    "人中之龙",
    "立锥之地",
    "抛砖引玉",
    "北面称臣",
);

$chengyu3=array('酒', '山');
$chengyue=array(
    array("填空组成词语：<br>神（）（）神<br>精（）（）精<br>痛（）（）痛", "乎 其 、 益 求 、 定 思"),
    array("最难听的歌曲：陈词滥调；<br>最绵长的口水：垂延三尺；<br>最宽阔的胸怀：（                 ）<br>最反常的天气：（                 ）", "虚怀若谷、六月飞雪"),
    array("看数字猜成语：<br>12345609 <br>1256789<br>3.5<br>9寸+1寸=1尺 ", "七零八落、丢三落四、不三不四、得寸进尺"),
    array("谁是主角：成语很多来源于故事，说出下列成语故事的主角<br>三顾茅庐<br>入木三分<br>背水一战", "刘备、王羲之、韩信"),
    array("判断成语使用是否恰当：<br>这次商品博览会，聚集了全国各种各样的商品，真是<red>浩如烟海</red><br>
   初春，乍暖还寒。他穿着冬装，漫步在广阔的田野中，仍然觉得<red>不寒而栗</red>", "错误"),
    array("1）填地名：<br>（  ）亲友如相问，一片冰心在玉壶。<br>（  ）朝雨浥轻尘，客舍青青柳色新。<br>2）填季节：<br>银烛（）光冷画屏，轻罗小扇扑流萤。", "洛阳  渭城  秋 "),
    array("说出和下列诗词有关的风景胜地：<br>1）两岸猿声啼不住，轻舟已过万重山 <br>2）会当凌绝顶，一览众山小 ", "三峡    泰山"),
    array("“但使龙城飞将在，不教胡马度阴山”中的“龙城飞将”指的是（  ）<br>A、汉朝名将霍去病  B、汉朝名将李广 C、赵国名将廉颇  D、三国名将赵云", "B"),
    array("你能从中看出诗人描写的季节吗？<br>1）月落乌啼霜满天，江枫渔火对愁眠。（   ）<br>2）天阶夜色凉如水，卧看牵牛织女星。（    ）", "秋   夏"),
    array("准确读出下面词的读音：高丽  鄱阳湖 胴体", "（li 二声）   （po二声）   （dong四声）"),
    array("最土的汉字", "垚（读尧）"),
    array("汉字溯源：例：“又”最初的字形像人的右手，所以现在许多由“又”组成的字中“又”都有手的的意思。<br>以下哪个字中，“又”的取义与手无关？<br>A.友      B.取      C.受      D.劝", "D"),
);

$chengyu4=array(
    array("1《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("2山重水复疑无路，柳暗花明又一村", "绝处逢生"),
    array("3《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("4山重水复疑无路，柳暗花明又一村", "绝处逢生"),
    array("5《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("6山重水复疑无路，柳暗花明又一村", "绝处逢生"),
    array("7《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("8山重水复疑无路，柳暗花明又一村", "绝处逢生"),
    array("9《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("10山重水复疑无路，柳暗花明又一村", "绝处逢生"),
    array("11《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("12山重水复疑无路，柳暗花明又一村", "绝处逢生"),
);

//全局变量获取数据库
$db = new Workerman\MySQL\Connection('localhost', '3306', 'chengyu', 'chengyu', 'chengyu');//本机为3306端口

//抢答器变量
$responder=0;

//客户端显示状态
$clientView['page']=1;//1为显示成语，2为显示抢答器, 3为显示题目
$clientView['chengyu']="欢迎参赛";
$clientView['question'] = '欢迎参赛';
$clientView['answer'] = '';

// 创建一个Worker监听端口,使用websocket协议通讯
$client_worker = new Workerman\Worker("websocket://$ip:1235");//处理与客户端的长连接
$client_worker->count=1;                            //启动1个进程
$client_worker->onConnect=function ($connection)use(&$clientView){
    echo "client connection success!\n";
    if ($clientView['page']==2){
        $connection->send(json_encode(array("showResponder"=>1)));
    }else if($clientView['page'] == 1) {
        $connection->send(json_encode(array('chengyu'=>$clientView['chengyu'])));
    } else if ($clientView['page'] == 3) {
        $connection->send(json_encode(array('cmd'=>'set_question', 'question' => $clientView['question'])));
        $connection->send(json_encode(array('cmd'=>'set_tablet_question', 'question' => $clientView['question'])));
    } else if ($clientView['page'] == 4) {
        $connection->send(json_encode(array('cmd'=>'set_question', 'question' => $clientView['question'])));
        $connection->send(json_encode(array('cmd'=>'set_tablet_question', 'question' => $clientView['question'])));
        $connection->send(json_encode(array('cmd'=>'set_answer', 'answer' => $clientView['answer'])));
        $connection->send(json_encode(array('cmd'=>'set_tablet_answer', 'answer' => $clientView['answer'])));
    }
};
$client_worker->onMessage=function ($connection,$data)use(&$responder,$client_worker){
    $raw_data = $data;
    $data=json_decode($data,true);
    if (isset($data['cmd']) && $data['cmd'] == 'set_tablet_question') {
        $clientView['page'] = 3;
        foreach ($client_worker->connections as $connection) {
            $connection->send($raw_data);
        }
        return;
    }
    if (isset($data['cmd']) && $data['cmd'] == 'set_tablet_answer') {
        $clientView['page'] = 4;
        foreach ($client_worker->connections as $connection) {
            $connection->send($raw_data);
        }
        return;
    }
    if (!$responder&&$data['act']=="responder"){
        $responder=1;
        echo "get responder\n";
        $connection->send(json_encode(array("responderSuccess"=>1)));
        foreach ($client_worker->connections as $connection) {
            echo "inside";
            $connection->send(json_encode(array("getResponder"=>1)));
        }
    }
};
$client_worker->onWorkerStart=function ($client_worker) use ($chengyu1,$chengyu2,$chengyu3,$chengyue, $chengyu4, $answer1,
    $db,&$responder,&$clientView){
    $control_worker=new Workerman\Worker("websocket://127.0.0.1:1234");   //处理与控制台的长连接
    $control_worker->onConnect=function ($connection){
        echo "controller connection success!\n";
    };
    $control_worker->onMessage=function ($controller_connection,$data)use($client_worker,$chengyu1,$chengyu2,$chengyu3, $answer1,
        $chengyue, $chengyu4, $db,&$responder,&$clientView){
        $raw_data = $data;
        $data=json_decode($data,true);
        if (isset($data['reset'])){
            if ($data['reset']=="client"){
                $response['chengyu']="欢迎参赛";
                echo "reset\n";
                $clientView['chengyu']="欢迎参赛";
                $clientView['page'] = 1;
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("chengyu"=>"欢迎参赛")));
                }
                $controller_connection->send(json_encode($response));
                return;
            }
        }

        if (isset($data['cmd'])) {
            foreach ($client_worker->connections as $c)
                $c->send($raw_data);
            return;
        }

        static $correctCount=0;
        static $i1=0, $i1game=0;
        static $i2=0;
        static $i3=0;
        static $cache2=array(
            'group1'=>array('breakLaw'=>0,'skip'=>0),
            'group2'=>array('breakLaw'=>0,'skip'=>0),
            'group3'=>array('breakLaw'=>0,'skip'=>0),
            'group4'=>array('breakLaw'=>0,'skip'=>0),
            'group5'=>array('breakLaw'=>0,'skip'=>0),
            'group6'=>array('breakLaw'=>0,'skip'=>0),
            'group7'=>array('breakLaw'=>0,'skip'=>0),
            'group8'=>array('breakLaw'=>0,'skip'=>0),
            'group9'=>array('breakLaw'=>0,'skip'=>0),
            'group10'=>array('breakLaw'=>0,'skip'=>0),
            'group11'=>array('breakLaw'=>0,'skip'=>0),
            'group12'=>array('breakLaw'=>0,'skip'=>0),
            'extraGroup'=>array('breakLaw'=>0,'skip'=>0)
        );

        if ($data['part'] == 'part1') {  // 第一关
            $game = (int)$data['game'] ;
            $group = (int)$data['group'] ;
            $clientView['answer'] = $answer1[$group - 1 + ($game - 1) * 12];
            $clientView['question'] = $chengyu1[$group - 1 + ($game - 1) * 12];
            if (isset($data['act']) && $data['act'] == 'set_answer') {
                $clientView['page'] = 4;
                $data = json_encode(array('cmd' => 'set_answer', "answer" => $clientView['answer'],
                    "msg" => "答案$game, $group:" . $clientView['answer']));
            } else {
                $clientView['page'] = 3;
                $data = json_encode(array('cmd' => 'set_question', "question" => $clientView['question'],
                    "msg" => "题目$game, $group:" . $clientView['question']));
            }

            $controller_connection->send($data);
            foreach ($client_worker->connections as $connection) {
                $connection->send($data);
            }
        }
        //控制台行为
        else if ($data['part']=="part2"){            //第二关
            $cache = &$cache2;
            if ($data['act']=="showChengyu"){
                echo $data['act']."\n";
                $clientView['page']=1;
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("showChengyu"=>1)));
                }
                return;
            }
            $response['part']=$data['part'];
            echo $data['part']."\n";
            echo "{$data['group']}: {$data['act']}\n";
            $response['msg']="";
            $response['msg'].="{$data['group']}: {$data['act']}";

            if ($data['act']=="end"){                                              //该组回合结束
                $row_count = $db->update('sum')->cols(array($data['part']=>$correctCount))->where('name=:name')->bindValues(array('name'=>$data['group']))->query();
                if ($row_count>0){
                    $response['msg'].="{$data['group']}: 保存成绩成功<br>";
                }else{
                    $response['msg'].="{$data['group']}: 保存成绩失败！<br>";
                }
                $clientView['chengyu']="欢迎参赛";
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("chengyu"=>"欢迎参赛")));
                }
                $response['chengyu']="欢迎参赛";
                $controller_connection->send(json_encode($response));
                return;
            }
            elseif ($data['act']=="start"){                                            //该组回合开始
                $cache[$data['group']]['breakLaw']=0;
                $cache[$data['group']]['skip']=0;
                $correctCount=0;
                $chengyu=$chengyu2[++$i2];
                $response['chengyu']=$chengyu;
                $clientView['chengyu']=$chengyu;
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("chengyu"=>$chengyu)));
                }
                $controller_connection->send(json_encode($response));
                return;
            }
            if ($cache[$data['group']]['breakLaw']>1){
                $response['alrt']="{$data['group']} 犯规数已经达到两次,该回合结束";
                $controller_connection->send(json_encode($response));
                return;
            }

            if ($cache[$data['group']]['breakLaw']==1&&$data['act']=="breakLaw"){       //犯规, 已经超过次数
                $cache[$data['group']][$data['act']]++;
                $response['msg'].="{$data['group']}: die for Break Law<br>";
                echo "{$data['group']}: die for Break Law\n";
                $response['alrt']="{$data['group']} 犯规达到两次,回合结束";
                $clientView['chengyu']="欢迎参赛";
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("fail"=>"犯规达到两次,回合结束","chengyu"=>"欢迎参赛", 'cmd'=>'stop_timer')));
                }
                $response['chengyu']="欢迎参赛";
                $controller_connection->send(json_encode($response));
                return;
            }
            elseif ($cache[$data['group']]['skip']==1&&$data['act']=="skip"){          //跳过,但已经超过次数
                $response['alrt']="{$data['group']} 已经跳过一次,不能再次跳过";
                $response['msg'].="{$data['group']}: cannot skip<br>";
                echo "{$data['group']}: cannot skip\n";
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("fail"=>"已经选择跳过一次,不能再次跳过")));
                }
                $controller_connection->send(json_encode($response));
                return;
            }
            elseif($data['act']=="correct"){                                           //正确
                $correctCount++;
                $chengyu=$chengyu2[++$i2];
                $response['chengyu']=$chengyu;
                $clientView['chengyu']=$chengyu;
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("chengyu"=>$chengyu)));
                }
                $controller_connection->send(json_encode($response));
                return;
            }
            else {                                                                     //跳过,或错误,且没超过次数
                $chengyu=$chengyu2[++$i2];
                $cache[$data['group']][$data['act']]=1;
                $response['chengyu']=$chengyu;
                $clientView['chengyu']=$chengyu;
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("chengyu"=>$chengyu)));
                }
                $controller_connection->send(json_encode($response));
                return;
            }
        }  // 第二关
        elseif ($data['part']=="part3"){            //第三关
            if ($data['act'] == 'question') {
                $c = $chengyu3[$i3];
                $i3 = ($i3 + 1) % sizeof($chengyu3);
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("chengyu"=>$c)));
                }
                $controller_connection->send(json_encode(array('msg'=>'题目：'.$c)));
            }
        }
        elseif($data['part']=="part4"){                                            //第四关
            $response['msg']="";
            $response['part']="part4";
            if ($data['act']=="showResponder"){
                echo $data['act']."\n";
                $clientView['page']=2;
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("showResponder"=>1)));
                }
                $response['msg'].=$data['act']."<br>";
                $controller_connection->send(json_encode($response));
                return;
            }
            if ($data['act']=='resetResponder'){
                $responder=0;
                echo $data['act']."\n";
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("resetResponder"=>1)));
                }
                $response['msg'].=$data['act']."<br>";
                $controller_connection->send(json_encode($response));
                return;
            }
            if ($data['act']=='set-part4-board') {
                $group1_score = $db->select('part4')->from('sum')->where('name="'.$data['group1'].'"')->single();
                $group2_score = $db->select('part4')->from('sum')->where('name="'.$data['group2'].'"')->single();
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("cmd"=>'set-part4-board', 'part4_group1'=>$data['group1'],
                        'part4_group2'=>$data['group2'], 'part4_group1_score'=>$group1_score, 'part4_group2_score'=>$group2_score)));
                }
                $controller_connection->send(json_encode(array('msg'=>'显示第四关记分板')));
            }
        }

    };
    $control_worker->listen();                  //worker嵌套    必不可少
};

// 运行worker
Workerman\Worker::runAll();
?>