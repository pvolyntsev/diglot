<?php

return array (
    0 =>
        (object)(array(
            'id' => 1,
            'article_id' => -1,
            'paragraph_original' => 'As I alluded to in my last post (which I will be correcting shortly), I no longer work for Google. I still haven’t decided quite where I’m going to wind up - I’ve got a couple of excellent offers to choose between. But in the interim, since I’m not technically employed by anyone, I thought I’d do a bit of writing about some professional things that are interesting, but that might have caused tension with coworkers or management.',
            'paragraph_translate' => '',
            'date_modified' => 1462990179,
            'sortorder' => 1,
        )),
    1 =>
        (object)(array(
            'id' => 0,
            'article_id' => -1,
            'paragraph_original' => 'Google is a really cool company. And they’ve done some really amazing things - both outside the company, where users can see it, and inside the company. There are a couple of things about the inside that aren’t confidential, but which also haven’t been discussed all that widely on the outside. That’s what I want to talk about.',
            'paragraph_translate' => '',
            'date_modified' => 1462990179,
            'sortorder' => 2,
        )),
    2 =>
        (object)(array(
            'id' => -1,
            'article_id' => -1,
            'paragraph_original' => 'The biggest thing that makes Google’s code so good is simple: code review. That’s not specific to Google - it’s widely recognized as a good idea, and a lot of people do it. But I’ve never seen another large company where it was such a universal. At Google, <em>no code</em>, for any product, for any project, gets checked in until it gets a positive review.',
            'paragraph_translate' => 'Самая значимая вещь, которая делает код в компании Google таким хорошим проста — code review (далее CR). Google не единственная компания, использующая CR. Всем известно, что это хорошая идея и множество разработчиков делают это. Но я не видел ни одной другой большой компании, в которой CR был бы так грамотно внедрен. В Google ни одна линия кода не уходит в production пока не получит позитивную оценку на CR.',
            'date_modified' => 1462990179,
            'sortorder' => 3,
        )),
    3 =>
        (object)(array(
            'id' => -2,
            'article_id' => -1,
            'paragraph_original' => '<em>Everyone</em> should do this. And I don’t just mean informally: this should really be a universal rule of serious software development. Not just product code - everything. it’s not that much work, and it makes a huge difference.',
            'paragraph_translate' => 'Вы должны уделять внимание CR. Это непременное условие для разработки любого программного обеспечения на серьезном уровне. CR должен применяться не только для кода который уходит в production, но вообще для всего. Это не такая большая разница во времени как вы думаете, но разница в качестве получается огромна.',
            'date_modified' => 1462990179,
            'sortorder' => 4,
        )),
    4 =>
        (object)(array(
            'id' => -3,
            'article_id' => -1,
            'paragraph_original' => 'What do you get out of code review?',
            'paragraph_translate' => 'Что же вы получите от использования CR?',
            'date_modified' => 1462990179,
            'sortorder' => 5,
        )),
    5 =>
        (object)(array(
            'id' => -4,
            'article_id' => -1,
            'paragraph_original' => 'There’s the obvious: having a second set of eyes look over code before it gets checked in catches bugs. This is the most widely cited, widely recognized benefit of code review. But in my experience, it’s the <em>least</em> valuable one. People <em>do</em> find bugs in code review. But the overwhelming majority of bugs that are caught in code review are, frankly, trivial bugs which would have taken the author a couple of minutes to find. The bugs that actually take time to find don’t get caught in review.',
            'paragraph_translate' => 'Очевидное: одна голова хорошо, а две лучше. Как минимум еще один человек просмотрит ваш код перед тем, как он будет проверен в реальных условиях (баги). Это наиболее часто упоминающийся профит от CR. Но мой опыт говорит, что это как раз менее всего ценно. Коллеги действительно находят ошибки в вашем коде, но подавляющее большинство таких ошибок найденных в процессе code review, прямо говоря, тривиальные вещи, которые автор кода найдет за несколько минут. Баги, на которые действительно нужно потратить время не ловятся на CR.',
            'date_modified' => 1462990179,
            'sortorder' => 6,
        )),
    6 =>
        (object)(array(
            'id' => -5,
            'article_id' => -1,
            'paragraph_original' => 'The biggest advantage of code review is purely social. If you’re programming and you <em>know</em> that your coworkers are going to look at your code, you program differently. You’ll write code that’s neater, better documented, and better organized -- because you’ll <em>know</em> that people who’s opinions you care about will be looking at your code. Without review, you know that people will look at code eventually. But because it’s not immediate, it doesn’t have the same sense of urgency, and it doesn’t have the same feeling of personal judgement.',
            'paragraph_translate' => 'Самое большая польза от code review носит социальный характер. Если вы программист и вы знаете, что ваши коллеги обязательно посмотрят ваш код, вы размышляете по-другому. Вы будете писать аккуратный, хорошо документированный и организованный код, потому как вы знаете, что люди, мнение о коде которых вам важно, внимательно проверят отправленный на review код. Без CR, вы также знаете, что другие люди посмотрят ваш код. Но вы понимаете, что это произойдет не сразу, поэтому этот факт не оказывает такого подсознательного эффекта.',
            'date_modified' => 1462990179,
            'sortorder' => 7,
        )),
    7 =>
        (object)(array(
            'id' => -6,
            'article_id' => -1,
            'paragraph_original' => 'There’s one more big benefit. Code reviews <em>spread knowledge</em>. In a lot of development groups, each person has a core component that they’re responsible for, and each person is very focused on their own component. As long as their coworkers components don’t <em>break</em> their code, they don’t look at it. The effect of this is that for each component, only one person has <em>any</em> familiarity with the code. If that person takes time off or - god forbid - leaves the company, <em>no one</em> knows anything about it. With code review, you have at least <em>two</em> people who are familiar with code - the author, and the reviewer. The reviewer doesn’t know as much about the code as the author - but they’re familiar with the design and the structure of it, which is incredibly valuable.',
            'paragraph_translate' => 'Другое большое преимущество — это распространение знаний. Во многих командах, у каждого отдельного программиста есть кусок кода в проекте, за который он ответственен, и этот программист сфокусирован именно на этот код. Пока коллеги не поломают что-то связанное с этим кодом, они на него не обращают внимания. Побочный эффект от этого в том, что для каждого компонента существует только один человек, который полностью понимает как он работает. Если этот человек не укладывается в сроки или — упаси Боже — покидает компанию, не останется никого, кто знаком с кодом компонента. С CR будет как минимум два человека, которые знакомы с кодом — автор и reviewer. Reviewer не знает код так, как его знает автор, но он знаком со структурой и архитектурой кода, что очень значимо.',
            'date_modified' => 1462990179,
            'sortorder' => 8,
        )),
    8 =>
        (object)(array(
            'id' => -7,
            'article_id' => -1,
            'paragraph_original' => 'Of course, nothing is every completely simple. From my experience, it takes some time before you get good at reviewing code. There are some pitfalls that I’ve seen that cause a lot of trouble - and since they come up particularly frequently among inexperienced reviewers, they give people trying code reviews a bad experience, and so become a major barrier to adopting code review as a practice.',
            'paragraph_translate' => 'Конечно же, это не просто. Из моего опыта могу сказать, что нужно время чтобы наладить хороший процесс CR. Я знаю несколько подводных камней, которые могут вызвать проблемы. Пока эти камни периодически вылезают CR может оставаться на плохом уровне, быть в тягость и препятствовать принятию в ежедневный workflow.',
            'date_modified' => 1462990179,
            'sortorder' => 9,
        )),
    9 =>
        (object)(array(
            'id' => -8,
            'article_id' => -1,
            'paragraph_original' => 'The biggest rule is that the point of code review is to find problems in code before it gets committed - what you’re looking for is <em>correctness</em>. The most common mistake in code review - the mistake that <em>everyone</em> makes when they’re new to it - is judging code by whether it’s what the reviewer would have written.',
            'paragraph_translate' => 'Главное правило — целью CR является нахождение проблем в коде перед тем как он будет закоммичен, т.е. правильность. Самая распространенная ошибка в CR у новичков это проверять код, основываясь на том как бы это сделал он.',
            'date_modified' => 1462990179,
            'sortorder' => 10,
        )),
    10 =>
        (object)(array(
            'id' => -9,
            'article_id' => -1,
            'paragraph_original' => 'Given a problem, there are usually a dozen different ways to solve it. Andgiven a solution, there’s a million ways to render it as code. As a reviewer, your job isn’t to make sure that the code is <em>what you would have written</em> - because <em>it won’t be</em>. Your job as a reviewer of a piece of code is to make sure that the code <em>as written by its author</em> is correct. When this rule gets broken, you end up with hard feelings and frustration all around - which isn’t a good thing.',
            'paragraph_translate' => 'Обычно существует несколько путей решения одного и того же. Помимо этого, есть миллион способов написать задуманное в виде кода. Задача reviewerа, не сделать так, чтобы написанный код был похож на то, чтобы он написал, нет — он никогда не будет таким. Задача reviewerа — удостовериться в том, что код, написанный автором корректен. Когда нарушается это правило, вы в итоге придете к эмоциям и переживаниям, что не является тем, к чему вы стремитесь.',
            'date_modified' => 1462990179,
            'sortorder' => 11,
        )),
    11 =>
        (object)(array(
            'id' => -10,
            'article_id' => -1,
            'paragraph_original' => 'The thing is, this is <em>such</em> a thoroughly natural mistake to make. If you’re a programmer, when you look at a problem, you can <em>see</em> a solution - and you think of what you’ve seen as <em>the</em> solution. But it isn’t - and to be a good reviewer, you need to get that.',
            'paragraph_translate' => 'Дело в том, что это совершенно естественная ошибка. Если вы программист, когда вы смотрите на проблему в коде, вы можете сразу видеть способ ее решить и вы думаете, что то, что вы увидели и есть решение. Но это не так, и чтобы стать хорошим reviewerом нужно это понять.',
            'date_modified' => 1462990179,
            'sortorder' => 12,
        )),
    12 =>
        (object)(array(
            'id' => -11,
            'article_id' => -1,
            'paragraph_original' => 'The second major pitfall of review is that people feel obligated to say <em>something</em>. You know that the author spent a lot of time and effort working on the code - shouldn’t you say <em>something</em>?',
            'paragraph_translate' => 'Второй по значимости подводный камень то, что люди чувствуют необходимость сказать что-либо. Вы знаете, что автор потратил достаточно времени и сил, работая над кодом и вроде как вы должны высказать свое мнение.',
            'date_modified' => 1462990179,
            'sortorder' => 13,
        )),
    13 =>
        (object)(array(
            'id' => -12,
            'article_id' => -1,
            'paragraph_original' => 'No, you shouldn’t.',
            'paragraph_translate' => 'Нет, вы не должны.',
            'date_modified' => 1462990179,
            'sortorder' => 14,
        )),
    14 =>
        (object)(array(
            'id' => -13,
            'article_id' => -1,
            'paragraph_original' => 'There is never anything wrong with just saying "Yup, looks good". If you constantly go hunting to try to find <em>something</em> to criticize, then all that you accomplish is to wreck your own credibility. When you repeatedly make things to criticize just to find something to say, then the people who’s code you review will learn that when you say something, that you’re just saying it to fill the silence. Your comments won’t be taken seriously.',
            'paragraph_translate' => 'Вполне нормально просто сказать «Выглядит хорошо». Если вы постоянно пытаетесь найти что-нибудь покритиковать, тогда все чего вы добьетесь так это подорвать свой авторитет и поломать отношения в команде. Когда вы критикуете код только для того чтобы найти что сказать, тогда люди чей код вы проверяете поймут, что вы пишете только для того чтобы что-то написать и ваши комментарии не будут воспринимать всерьез.',
            'date_modified' => 1462990179,
            'sortorder' => 15,
        )),
    15 =>
        (object)(array(
            'id' => -14,
            'article_id' => -1,
            'paragraph_original' => 'Third is speed. You shouldn’t rush through a code review - but also, you need to do it <em>promptly</em>. Your coworkers are <em>waiting</em> for you. If you and your coworkers aren’t willing to take the time to get reviews done, and done quickly, then people are going to get frustrated, and code review is just going to cause frustration. It may seem like it’s an interruption to drop things to do a review. It shouldn’t be. You don’t need to drop everything the moment someone asks you to do a review. But within a couple of hours, you will take a break from what you’re doing - to get a drink, to go to the bathroom, to talk a walk. When you get back from that, you can do the review and get it done. If you do, then no one will every be left hanging for a long time waiting on you.',
            'paragraph_translate' => 'Третье — скорость. Не нужно сломя голову бежать проверять только что посланный на review код, но с другой стороны нужно делать это быстро. Ваши коллеги ждут вас. Если вы и ваши коллеги не уделяете время тому, чтобы CR был сделан, причем сделан быстро, тогда CR может стать причиной недовольства людей в коллективе. Может показаться, что это переключение фокуса — взяться за CR. Это не совсем так. Не нужно бросать все в тот момент, когда новый код послан на review. Но в течение нескольких часов вы совершенно точно сделаете паузу для того, чтобы попить что-нибудь, сходить в туалет или просто походить. Когда вы вернетесь с паузы уделите внимание CR. Если вы возьмете это в привычку, то никто в команде не будет подолгу ожидать ваш review и он не будет доставлять никакого дискомфорта в работе.',
            'date_modified' => 1462990179,
            'sortorder' => 16,
        )),
);