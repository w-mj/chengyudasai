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
A. 暴殄天物(tian三声)
B. 咋舌(za三声)
C. 恽代英(hui一声)
D. 郫县(pi三声)
', // TODO: 颜色
    '以下红字读音不相同的一组是（  ）
A. <span color="red">苍</span>  创造  疮痍  踉跄
B. 斫痕  洗濯  商酌  烧灼
C. 拮据  诘责  劫难  碣石
D. 茶几  滑稽  羁绊  畸形  
',
    '以下红字声调不相同的一组是（   ）
A. 蝉蜕  兑现  脱离  喜悦
B. 炽热  翅膀  充斥  叱咤
C. 小憩  哭泣  放弃  契约
D. 遒劲  虬须  泅水  裘皮
',
    '下列注音完全正确的一组是（   ）
A. 囿于成见(you四声 yú chéng jiàn)
B. 跋扈(bá huo四声)
C. 壅塞(yōng sai一声)
D. 日冕(rì gui三声)
',
    '春hui（一声）（   ）
A. 晖
B. 辉
C. 珲
',
    ' wei编三绝（   ）
    A. 韦
    B. 苇
    C. 纬
    ',
    '河清海yan（四声）（  ）
A. 晏
B. 沇
C. 漹
D. 溎
',
    '下列词语中，没有错别字的一项是（   ）
A. 派遣    浑然天成     家喻户晓     前事不忘，后世之师
B. 安详    变幻莫测     与日俱增     心有灵犀一点通
C. 迁徙    目不识丁     获益匪浅     一年之际在于春
D. 惩诫    得天独厚     忧心忡忡     有福同享，有难同当
',
    '下列句子中加字及字的注音都正确的一项是（   ）
A. 我这张笨拙(zhuó)的嘴，想到的也说不出。
B. 他一手拿着布，一手攥(zhuàn)着钱，滞笨地转过身子。
C. 他勉强(qiǎng)地从座位上站起来。
D. 我们应该本着“承(chéng)前毖后，治病救人”的态度开展批评与自我批评。
',
    '下列词语书写全部正确的一项是（   ）
A. 夜宵    坚苦卓绝    鸦雀无声
B. 肆虐    风糜一时    出类拔萃
C. 安排    枯躁乏味    病入膏肓
D. 脉搏    世外桃源    应接不瑕
',
    ' 下列词语中红字的读音，全都不相同的一项是（   ）
A. 笨拙 茁壮 罢黜 咄咄逼人
B. 恬静 聒噪 甜蜜 舔犊情深
C. 踉跄 创伤 悲怆 满目疮痍
D. 炫耀 琴弦 船舷 头晕目眩
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
        A.	春蚕到死丝方尽，蜡炬成灰泪始干。
        B.	身无彩凤双飞翼，心有灵犀一点通。
        C.	秋阴不散霜飞晚，留得枯荷听雨声。
        D.	刘郎已恨蓬山远，更隔蓬山一万重。
',
    '《秋风词·三五七言》李白“早知如此绊人心”请接下句。',
    '请根据大屏幕上的词回答出贺铸所做的这首词所对应的词牌名
        凌波不过横塘路，但目送，芳尘去，锦瑟华年谁与度？月桥花院，琐（suo）窗朱户，只有春知处。
        碧云冉冉蘅（heng）皋（gao）暮，彩笔新题断肠句。试问闲情都几许？一川烟草，满城风絮，梅子黄时雨。
',
    '秦淮八艳之一的柳如是原名柳隐，号如是。请问她因为辛弃疾《贺新郎》中的哪几句而自号“如是”？',
    '《临安春雨初霁》陆游“素衣莫起风尘叹”请接下句',
    '在我国诗词史上有一朵奇葩，这位文学家据传是上古高阳氏的子孙，他曾说要“朝饮木兰之坠露，夕餐秋菊之落英”，也曾想要让蛟龙来帮他开路，凤皇帮他扛旗。请问这位想象奇绝的文学家是谁？',
    '郑思肖曾在自己的代表作中写道“花开不并百花丛，独立疏篱趣未穷。宁可枝头抱香死，何曾吹落北风中？”请问这首诗描写的是什么？',
    '唐代诗人李白在唐朝可谓名倾一时，杜甫评价他“白也诗无敌”，白居易评价他“曾有惊天动地文”，唐伯虎评价他“我愧虽无李白才”然而像李白这样优秀的诗人也有自己敬佩景仰的人。李白曾在自己的诗中评价他说“红颜弃轩冕，白首卧松云。醉月频中圣，迷花不事君。高山安可仰，徒此挹清芬。”请问这个让大诗人李白都感到敬佩的诗人他是谁呢？',
    '辛弃疾的《清平乐·村居》（茅檐低小）中主人公有几个儿子？ 
    A.1个
    B.词中没提到他有儿子
    C.2个
    D.3个
',
    '请选出下列有错误的一项
A.	王昌龄-------被称为“七绝圣手”--------写过“洛阳亲友如相问，一片冰心在玉壶。”
B.	李清照-------字易安--------写过“兴尽晚回舟，误入藕花深处。”
C.	贺铸-------宋代词人--------写过“当年不肯嫁春风，无端却被秋风误。”
D.	柳永------歌女妓女为其举办吊柳会------写过“忍把浮名，换了浅斟低唱！”
',
    '唐朝是诗歌的代表时期之一，唐朝诗人如过江之鲫，多不胜数，据传在唐朝290年间竟然出现了207位女诗人，其中有四位女诗人被并称为“唐代四大女诗人”，请任意说出其中的三位。',
    '《红楼梦》第四十九回中，宝钗笑香菱道：“满嘴里说的是什么：怎么是‘杜工部之沉郁，韦苏州之淡雅，温八叉之绮靡，李义山之隐僻。’放着两个现成的诗家不知道，提那些死人做什么！”，请问宝钗口中的“杜工部”，“韦苏州”，“温八叉”，“李义山”分别是哪四位诗人？',

    '1. 下列词语中加点字读音不完全相同的一项是（  ）
A. 定单 钉死 锭子 盯梢
B. 休憩 迄今 器材 哭泣
C. 谛听 缔造 帝王 递增 
D. 义务 游弋 艺术 议会
',
    '下面红字注音正确的一项是（  ）
A. 猝然(cù)　镂空(lòu)　拈轻怕重(zhān)
B. 蜕变(tuì)　畸形(ji一声)　沁人心脾(pi二声)
C. 酝酿(yùn)　绽放(zhàn)　忍俊不禁(jin四声) 
D. 修葺(qì)　窥视(kuī)　杞人忧天(jǐ)
',
    '下面红字注音正确的一项是（   ）
A. 间歇(jian四声)
B. 颠茄(jia一声)
C. 熨帖(tie四声)
D. 图们江(men轻声)
',
    '下列注音完全正确的一组是（   ）
A. 襁褓(qiang三声 bǎo)
B. 三聚氰胺(sān jù qíng an一声)
C. 癞蛤蟆(lài há mo轻声)
D. 拾掇(shí duo一声)
',
    '下列注音完全正确的一组是（   ）
A. 驽马(nu二声 mǎ )
B. 兄弟阋墙(xiōng dì ni四声 qiáng)
C. 汗水涔涔(hàn shuǐ cen二声 cen二声)
D. 荦荦大端(qiong二声 qiong二声 dà duān)
',
    '下列注音完全正确的一组是（   ）
A. 方兴未艾(fāng xīng wèi ai四声)
B. 火铳(huǒ tong三声)
C. 反刍(fǎn zou一声) 
D. 怄气(ou一声 qì)
',
    '下列注音完全正确的一组是（   ）
A. 毕肖(bì xiao四声)
B. 揉搓(róu cuo轻声)
C. 尔虞我诈(ěr yu三声 wǒ zhà)
D. 择菜(zhai一声 cài)
',
    '下列注音完全正确的一组是（   ）
A. 皴裂(jun一声 liè)
B. 扑尔敏(pu三声 ěr mǐn)
C. 造诣(zào zhi三声)
D. 颐指气使(yi二声 zhǐ qì shǐ)
',
    '以下声调相同的一组是（   ）
A. 矩、锯、毓
B. 俚、媪、鸨
C. 旒、蹯、菡
D. 耶、佻、坳
',
    '下列词语的音、形和对加点字字义的解释全都正确的一项是（   ）
A. 贮（zhù）藏    痉挛    希冀（希望）
B. 剽（piāo）悍    瞬息   热忱（真实的情意）
C. 旌（jīn）旗      惋惜    迁徙（调动）
D. 怪癖（pì）       舆论    肆虐（残暴）
',
    '列注音完全正确的一组是（   ）
A. 翘楚(qiao二声 chǔ)
B. 滂沱(pang二声 tuó)
C. 暮霭(mù ai二声 )
D. 摒除(bing三声 chú)
',
    '下列注音完全正确的一组是（   ）
A. 轮毂(lún gu三声)
B. 杀手锏(shā shǒu jian一声)
C. 鼹鼠(yan四声 shǔ)
D. 鳜鱼(jue二声 yú)
',

    '“鸟尽弓藏”是说古代一些成功人士事情成功之后，就把曾经的功臣废黜罢免。请问这个成语最初讲述的是谁的故事？
A.勾践和范蠡B.刘邦和韩信C.赵匡胤和曹彬
',
    '“投鼠忌器”的意思是家里进了老鼠，想用东西砸死老鼠又怕砸坏老鼠附近的用具。请问这句话的出处来自于以下哪两个人之间的对话？
A.刘备和关羽B.项羽和范增C.嬴政和王翦
',
    '“韦编三绝”的意思是编书简用的绳子都断了三次，比喻读书勤奋。请问这个成语最初指的是谁读书勤奋？
    A.颜渊B.孔子C.孟子',
    '“不求甚解”的意思是读书只求知道个大概，不求彻底了解。请问这个成语最早说的是谁读书不求甚解？
A.范仲淹B.欧阳修 C.陶渊明
',
    '“指鹿为马”是用来形容一些人故意颠倒黑白，混淆是非。请问，这个成语最初讲的是下列哪个人指着鹿却非说是马？
A.董卓B.赵高C.曹操
',
    '“破釜沉舟”形容的是做一件事情下定决心，义无反顾。请问这个成语最初说的是下列哪位人物大战之前砸锅又沉船？
A.汉高祖刘邦 B.西楚霸王项羽 C.淮阴侯韩信
',
    '请问“一家之言”是谁的文学观点？
A.司马迁B.欧阳修C.曹操
',
    '“东窗事发”是用来比喻坏蛋的阴谋已败露。请问这个成语最初讲的是以下哪位奸臣的阴谋败露了？
A.董卓B.秦桧C.和珅
',
    '“才占八斗”多用来形容古代的大才子学问高超，诗才敏捷。请问这句话最初是用来评价哪位才子的？
A.苏轼B.李白C.曹植
',
    '“暗度陈仓”是楚汉争霸时期刘邦集团的一次著名军事行动。请问是谁装作要从栈道进攻关中，却带领主力部队袭击了陈仓，进而攻人咸阳？
A.萧何B.韩信 C.张良
',
    '“洛阳纸贵”最早形容的是谁的文学作品盛极一时？
A.班固B.左思C.班超
',
    '“一字千金”最早指的是谁的举动
A.吕不韦 B,范睢 C.白起
',

    '宋朝著名诗人，词人，文学家苏轼曾经在自己的一首《西江月》中如是写道“素面倒嫌粉涴（wo），洗妆不褪唇红。高情已逐晓云空，不与梨花同梦。”请问这首词描写的是什么花？',
    '琼瑶阿姨曾经写过一本小说名字叫做《一帘幽梦》，实际上这本小说的名字引用自秦少游的一首《八六子》，请问具体引用自这首词中的哪两句话呢？',
    '《绮怀》黄景仁“似此星辰非昨夜”请接下句',
    '苏轼《定风波》中“万里归来颜愈少，微笑，笑时犹带岭梅香。试问，‘岭南应不好？’，却道”请接下句',
    '朱庆馀在《闺意献张水部》一诗中曾写道“洞房昨夜停红烛，待晓堂前拜舅姑。妆罢低声问夫婿，画眉深浅入时无。”意思是问自己答的卷子还和不和张籍的心意，张籍看到诗后认为他卷子写得非常好，同时也给他回了一首诗。请用张籍原诗说明张籍是怎么夸奖他的（背诵一至两句即可）',
    '《长门怨》李白“月光欲到长门殿”请接下句',
    '请根据大屏幕上的词回答出辛弃疾所做的这首词所对应的词牌名
更能消、几番风雨，匆匆春又归去。惜春长怕花开早，何况落红无数。春且住。见说道、天涯芳草无归路。怨春不语。算只有殷勤、画檐蛛网，近日惹飞絮。
长门事，准拟佳期又误，蛾眉曾有人妒。千金纵买相如赋，脉脉此情难诉？君莫舞。君不见、玉环飞燕皆尘土！闲愁最苦。休去倚危栏，斜阳正在，烟柳断肠处。
',
    '宋代词人晏几道曾经写过一首《临江仙》
梦后楼台高锁，酒醒帘幕低垂。去年春恨却来时，落花人独立，微雨燕双飞。
记得小蘋初见，两重心字罗衣。琵琶弦上说相思，当时明月在，曾照彩云归。
词中“落花人独立，微雨燕双飞。”为流传千古的好句子，但实际上这两句词是他引用的前人古诗，请问引用的是唐代诗人翁宏的哪一首诗？
',
    '《鹧鸪天》晏几道“蒙混惯得无拘检”请接下句',
    '请问杨万里诗中“坐看深来尺许强，偏於薄暮发寒光。半空舞倦居然懒，一点风来特地忙。”描写的是什么？',
    '李商隐诗中“唯有绿荷红菡萏，卷舒开合任天真。”诗中的“菡萏”所指的是什么？',
    '《浣溪沙》纳兰性德“但是有情皆满愿，更从何处著思量”请接下句',
);

$chengyu2=array(
    '一衣带水',
    '作舍道旁',
    '厉兵秣马',
    '匠石运斤',
    '冯唐易老',
    '以邻为壑',
    '口出狂言',
    '倚马千言',
    '铸山煮海',
    '罄竹难书',
    '掷地有声',
    '卓尔不群',
    '秋风过耳',
    '啮雪餐毡',
    '浅尝辄止',
    '休戚相关',
    '与虎谋皮',
    '亦步亦趋',
    '穷且益坚',
    '助纣为虐',
    '颠扑不破',
    '糟糠之妻',
    '老态龙钟',
    '含饴弄孙',
    '仰人鼻息',
    '秘而不宣',
    '六韬三略',
    '响遏行云',
    '谨小慎微',
    '捉襟见肘',
    '作茧自缚',
    '入幕之宾',
    '买椟还珠',
    '如丧考妣',
    '白头如新',
    '首鼠两端',
    '一暴十寒',
    '枕戈待旦',
    '穷兵黩武',
    '满目疮痍',
    '白驹过隙',
    '指鹿为马',
    '唾壶击碎',
    '反求诸己',
    '一蹴而就',
    '罄竹难书',
    '董狐直笔',
    '目不交睫',
    '木梗之患',
    '负隅顽抗',
    '城狐社鼠',
    '草菅人命',
    '如椽大笔',
    '夙世冤家',
    '诟如不闻',
    '三荆同株',
    '百步穿杨',
    '一目十行',
    '不求甚解',
    '运筹帷幄',
    '口蜜腹剑',
    '郢书燕说',
    '短兵相接',
    '嗟来之食',
    '江郎才尽',
    '止戈为武',
    '枯鱼之肆',
    '屡试不爽',
    '名落孙山',
    '倒屣相迎',
    '不落窠臼',
    '拔山举鼎',
    '嫂溺叔援',
    '望门投止',
    '仰人鼻息',
    '长袖善舞',
    '吞炭漆身',
    '天网恢恢',
    '目光如炬'
);

$chengyu3=array(
    '黄',
    '火',
    '债',
    '寿',
    '寸木岑楼',
    '一饭之德',
    '作威作福',
    '饮水思源',
    '大智若愚',
    '老蚌生珠',
    '筚路蓝缕',
    '缘木求鱼',
    '煮豆燃萁',
    '箪食壶浆',
    '得陇望蜀',
    '卜昼卜夜',
    '买椟还珠',
    '外强中干',
    '坐怀不乱',
    '刘郎前度',
    '前倨后恭',
    '作奸犯科',
    '鸟尽弓藏',
    '汗牛充栋',
    '宴安鸩毒',
    '冠山戴粒',
    '别无长物',
    '越俎代庖',
    '拾人牙慧',
    '管中窥豹',
    '狗尾续貂',
    '家徒壁立',
    '投鼠忌器',
    '举案齐眉',
    '唇亡齿寒',
    '开门揖盗',
    '始终不渝',
    '李代桃僵',
    '利令智昏',
    '尾生抱柱',
    '孤注一掷',
    '危如累卵',
    '瘗玉埋香',
    '东窗事发',
    '按图索骥',
    '吴下阿蒙',
    '对簿公堂',
    '纲挈目张',
    '孝悌忠信',
    '毁家纾难',
    '宵鱼垂化',
    '退避三舍',
    '不逞之徒',
    '爱屋及乌',
    '登堂入室',
    '纸上谈兵',
    '高屋建瓴',
    '庄生梦蝶',
    '中流击楫',
    '草菅人命',
    '据鞍读书',
    '沉鱼落雁',
    '家徒四壁',
    '涸辙之鲋',
    '涣然冰释',
    '拾人牙慧',
    '南州冠冕',
    '洛阳纸贵',
    '刚愎自用',
    '不分轩轾',
    '一枕南柯',
    '因噎废食',
    '井渫不食',
    '胶柱鼓瑟',
    '下马冯妇',
    '鞭长莫及',
    '安步当车',
    '耳提面命',
    '一馈十起',
    '开门揖盗',
    '为蛇画足',
    '倾筐倒庋',
    '爱鹤失众',
    '阳春白雪',
    '过门不入',
    '屠龙之技',
    '画虎类犬',
    '三告投杼',
    '专横跋扈',
    '不即不离',
    '钟鼎人家',
    '集腋成裘',
    '比肩接踵',
    '墨突不黔',
    '倒行逆施',
    '使酒骂座',
    '朝乾夕惕',
    '杯水车薪',
    '铄石流金',
    '枕戈待旦',
    '杯水车薪',
    '望洋兴叹',
    '吐哺辍洗',
    '安步当车',
    '过犹不及',
    '倒行逆施',
    '不逞之徒',
    '发奸擿伏',
    '呕心沥血',
    '噤若寒蝉',
    '披星戴月',
    '纲举目张',
    '运斤成风',
    '噤若寒蝉',
    '不容置喙',
    '不寒而栗',
    '抱薪救火',
    '阳春白雪',
    '斗粟尺布',
    '强弩之末',
    '色厉内荏',
    '道听途说',
    '从善如流',
    '自惭形秽',
    '燕雀处堂',
    '却金暮夜',
    '寿陵失步',
    '舍旧谋新',
    '差强人意',
    '沆瀣一气',
    '书空咄咄',
    '三人成虎',
    '梧鼠技穷',
    '因势利导',
    '明火执械',
    '穷兵黩武',
    '杜口裹足',
    '与虎谋皮',
    '金口木舌',
    '亡猿祸木',
    '孔席不暖',
    '十浆五馈',
    '无妄之灾',
    '郑人买履',
    '子虚乌有',
    '大放厥词',
    '图穷匕见',
    '后起之秀',
    '日不暇给',
    '负隅顽抗',
    '鳞次栉比',
    '东窗事发',
    '小黠大痴',
    '去食存信',
    '石破天惊',
    '大放厥词',
    '才高八斗',
    '城下之盟',
    '弹冠相庆',
    '本末倒置',
    '亡秦三户',
    '抱残守缺',
    '危于累卵',
    '马革裹尸',
    '始作俑者',
    '防微杜渐',
    '东施效颦',
    '车载斗量',
    '因地制宜',
    '暗度陈仓',
    '城下之盟',
    '不为已甚',
    '沆瀣一气',
    '大笔如椽',
    '指鹿为马', '山穷水尽',
    '白衣卿相',
    '长袖善舞',
    '长驱直入',
    '才占八斗',
    '寸木岑楼',
    '别具肺肠',
    '马首是瞻',
    '大方之家',
    '兴丞相叹',
    '并日而食',
    '月下老人',
    '逢人说项',
    '不得要领',
    '割席断交',
    '大功毕成',
    '白头如新',
    '推食解衣',
    '侧目而视',
    '尸位素餐',
    '挥戈回日',
    '千金买骨',
    '无所畏惧',
    '十面埋伏',
    '陈陈相因',
    '见猎心喜',
    '天罗地网',
    '河清海晏',
    '班荆道故',
    '不以为然',
    '一鞭先著',
    '见异思迁',
    '开门揖盗',
    '人鼠之叹',
    '喜结金兰',
    '箪食瓢饮',
    '不甚了了',
    '风起云飞',
    '目光如炬',
    '倚马可待',
    '霜露之疾',
    '一钱不值',
    '雪泥鸿爪',
    '开卷有益',
    '一厢情愿',
    '下笔成篇',
    '开天辟地',
    '带经而锄',
    '一蹴而就',
    '左提右挈',
    '千人所指',
    '日暮穷途',
    '写经换鹅',
    '抽薪止沸',
    '敝帚自珍',
    '不负众望',
    '小鸟依人',
    '万人之敌',
    '引狼入室',
    '博弈犹贤',
    '披肝沥胆',
    '余光分人',
    '洞若观火',
    '韦编三绝',
    '鹬蚌相争',
    '开诚布公',
    '捉襟见肘',
    '人琴俱亡',
    '俯拾皆是',
    '壮士解腕',
    '鹤发童颜',
    '投鼠忌器',
    '坚如磐石',
    '芒刺在背',
    '高屋建瓴',
    '间不容发',
    '五里雾中',
    '按图索骥',
    '期期艾艾',
    '尸位素餐',
    '偷梁换柱',
    '倒执手版',
    '同类相求',
    '安土重还',
    '车载斗量',
    '徙薪曲突',
    '触目惊心',
    '白云亲舍',
    '门可罗雀',
    '探骊得珠',
    '林林总总',
    '休戚相关',
    '唐突西施',
    '毕恭毕敬',
    '鹤立鸡群',
    '一夔已足',
    '髀肉复生',
    '以邻为壑',
    '别无长物',
    '后起之秀',
    '间不容发',
    '瞠目结舌',
    '故步自封',
    '胁肩谄笑',
    '残杯冷炙',
    '倾筐倒箧',
    '怙恶不悛',
    '不甚了了',
    '瓜田李下',
    '尸位素餐',
    '一言兴邦',
    '别无长物',
    '东门黄犬',
    '结草衔环',
    '掌上观文',
    '泾渭分明',
    '一狐之腋',
    '蓬荜增辉',
    '髀肉复生',
    '繁文缛节',
    '优孟衣冠',
    '左提右携',
    '空谷足音',
    '予取予求',
    '宋玉东墙',
    '分道扬镳',
    '一木难支',
    '沆瀣一气'
);

$chengyue=array(
    array("1山重水复疑无路，柳暗花明又一村1", "绝处逢生"),
    array("2《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("3山重水复疑无路，柳暗花明又一村", "绝处逢生"),
    array("4《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("5山重水复疑无路，柳暗花明又一村", "绝处逢生"),
    array("6《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("7山重水复疑无路，柳暗花明又一村", "绝处逢生"),
    array("8《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("9山重水复疑无路，柳暗花明又一村", "绝处逢生"),
    array("10《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
    array("11山重水复疑无路，柳暗花明又一村", "绝处逢生"),
    array("12《庄子·天运》:“故西施病心而矉其里，其里之丑人见而美之，归亦捧心而矉其里。其里之富人见之，坚闭门而不出；贫人见之，絜妻子而去之走。", "东施效颦"),
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
$clientView['page']=1;//1为显示成语，2为显示抢答器
$clientView['chengyu']="欢迎参赛";

// 创建一个Worker监听端口,使用websocket协议通讯
$client_worker = new Workerman\Worker("websocket://127.0.0.1:1235");//处理与客户端的长连接
$client_worker->count=1;                            //启动1个进程
$client_worker->onConnect=function ($connection)use(&$clientView){
    echo "client connection success!\n";
    if ($clientView['page']==2){
        $connection->send(json_encode(array("showResponder"=>1)));
    }else{
        $connection->send(json_encode(array('chengyu'=>$clientView['chengyu'])));
    }
};
$client_worker->onMessage=function ($connection,$data)use(&$responder,$client_worker){
    $data=json_decode($data,true);
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
$client_worker->onWorkerStart=function ($client_worker) use ($chengyu1,$chengyu2,$chengyu3,$chengyue, $chengyu4,
    $db,&$responder,&$clientView){
    $control_worker=new Workerman\Worker("websocket://127.0.0.1:1234");   //处理与控制台的长连接
    $control_worker->onConnect=function ($connection){
        echo "controller connection success!\n";
    };
    $control_worker->onMessage=function ($controller_connection,$data)use($client_worker,$chengyu1,$chengyu2,$chengyu3,
        $chengyue, $chengyu4, $db,&$responder,&$clientView){
        $raw_data = $data;
        $data=json_decode($data,true);
        if (isset($data['reset'])){
            if ($data['reset']=="client"){
                $response['chengyu']="欢迎参赛";
                echo "reset\n";
                $clientView['chengyu']="欢迎参赛";
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
            if ($data['cmd'] == 'show_page' && $data['page'] == 'friend')
                foreach ($client_worker->connections as $c)
                    $c->send(json_encode(array('cmd'=>'set_extra_questions', 'data'=>$chengyue)));
            else if ($data['cmd'] == 'show_page' && $data['page'] == 'part4')
                foreach ($client_worker->connections as $c)
                    $c->send(json_encode(array('cmd'=>'set_extra_questions', 'data'=>$chengyu4)));
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
            $game =(int)$data['game'];
            $data = json_encode(array('cmd'=>'set_question', "question"=>$chengyu1[$i1 + ($game - 1) * 12], "msg"=>'题目:'.$chengyu1[$i1 + ($game - 1) * 12]));
            echo $data.'\n';
            $controller_connection->send($data);
            foreach ($client_worker->connections as $connection) {
                $connection->send($data);
            }
            $i1 = ($i1 + 1) % 12;
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
                $chengyu=$chengyu1[++$i1];
                $response['chengyu']=$chengyu;
                $clientView['chengyu']=$chengyu;
                foreach ($client_worker->connections as $connection) {
                    $connection->send(json_encode(array("chengyu"=>$chengyu)));
                }
                $controller_connection->send(json_encode($response));
                return;
            }
            else {                                                                     //跳过,或错误,且没超过次数
                $chengyu=$chengyu1[++$i1];
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
                $c = $chengyu3[$i3++];
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

        }

    };
    $control_worker->listen();                  //worker嵌套    必不可少
};

// 运行worker
Workerman\Worker::runAll();
?>