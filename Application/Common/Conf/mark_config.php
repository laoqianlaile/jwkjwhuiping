<?php
return array(
    "REMARK_OPTION"=>[
        '重大'=>[
            'title'=>'国家社科基金军事学重大项目',
            '评价要点'=>[
                '1.研究团队取得成绩和对军事理论的贡献（满分30分）',
                '2.研究团队的实力（满分20分）',
                '3.研究项目的科学价值和军事价值（满分30分）',
                '4.研究思路和方案的创新性、可行性（满分20分）'
            ],
            '注意事项'=>[      '<b>1.研究团队取得成绩和对军事理论的贡献【优（26-30）；良（22-25）；中（18-21）；差（0-17）】。</b>已取得重要研究成果或者转化应用取得明显军事效益；担任重大、重点项目负责人或首席专家等；获得同行公认。',                    '<b>2.研究团队的实力【优（17-20）；良（14-16）；中（11-13）；差（0-10）】。</b>对本领域有深厚研究积累，创新能力强；团队成员知识和年龄结构合理，具有理技融合特性，有良好科研平台支撑；具备开展调查研究和实践验证的基础条件。',                '<b>3.研究项目的科学价值和军事价值【优（26-30）；良（22-25）；中（18-21）；差（0-17）】。</b>基础理论类项目，着重评价其原创性、前沿性，以及引领军事学未来发展的价值；应用理论类项目，着重评价其推动解决当前关键瓶颈问题的重要作用，以及提升作战能力和军队建设质量效益的意义。',			    '<b>4.研究思路和方案的创新性、可行性【优（17-20）；良（14-16）；中（11-13）；差（0-10）】。</b>研究思路和方案创新性强、科学合理。不过分强调研究路径的可行性和研究方案的完备性。'
            ],
            '评价内容'=>[
                'ps_cj'=>['field'=>'ps_cj','title'=>'成绩贡献','brief'=>'成绩贡献','minVal'=>0,'maxVal'=>30],
                'ps_ql'=>['field'=>'ps_ql','title'=>'发展潜力','brief'=>'发展潜力','minVal'=>0,'maxVal'=>20],
                'ps_jz'=>['field'=>'ps_jz','title'=>'科学、军事价值','brief'=>'科学军事价值','minVal'=>0,'maxVal'=>30],
                'ps_cx'=>['field'=>'ps_cx','title'=>'创新性','brief'=>'创新性','minVal'=>0,'maxVal'=>20]
            ]
        ],
        '重点'=>[
            'title'=>'国家社科基金军事学重点项目',
            '评价要点'=>[
                '1.申请人取得成绩和对军事理论的贡献（满分30分）',
                '2.申请人的发展潜力（满分30分）',
                '3.研究项目的科学价值和军事价值（满分20分）',
                '4.研究思路和方案的创新性、可行性（满分20分）'
            ],
            '注意事项'=>[    '<b>1.申请人取得成绩和对军事理论的贡献【优（26-30）；良（22-25）；中（18-21）；差（0-17）】。</b>已取得重要研究成果或者转化应用取得明显军事效益；担任过重点项目负责人；同行评价意见较好。',                    '<b>2.申请人的发展潜力【优（26-30）；良（22-25）；中（18-21）；差（0-17）】。</b>对本领域有较强研究积累，知识储备和科研经历丰富；勇于开拓创新，具有较好的洞察力、创造力；有良好团队背景和科研平台支撑；理技融合、战技结合型人才重点支持。',                    '<b>3.研究项目的科学价值和军事价值【优（17-20）；良（14-16）；中（11-13）；差（0-10）】。</b>基础理论类项目，着重评价其原创性、前沿性，以及潜在军事价值；应用理论类项目，着重评价其提升作战能力和军队建设质量效益的重要作用。',                    '<b>4.研究思路和方案的创新性、可行性【优（17-20）；良（14-16）；中（11-13）；差（0-10）】。</b>研究方案创新性强、科学合理。不过分强调研究路径的可行性和研究方案的完备性。'
            ],
            '评价内容'=>[
                'ps_cj'=>['field'=>'ps_cj','title'=>'成绩贡献','brief'=>'成绩贡献','minVal'=>0,'maxVal'=>30],
                'ps_ql'=>['field'=>'ps_ql','title'=>'发展潜力','brief'=>'发展潜力','minVal'=>0,'maxVal'=>30],
                'ps_jz'=>['field'=>'ps_jz','title'=>'科学、军事价值','brief'=>'科学军事价值','minVal'=>0,'maxVal'=>20],
                'ps_cx'=>['field'=>'ps_cx','title'=>'创新性','brief'=>'创新性','minVal'=>0,'maxVal'=>20]
            ]
        ],
//        'ps_cj'=>['field'=>'ps_cj','title'=>'成绩贡献','brief'=>'成绩贡献','minVal'=>0,'maxVal'=>2],
//        'ps_ql'=>['field'=>'ps_ql','title'=>'发展潜力','brief'=>'发展潜力','minVal'=>0,'maxVal'=>3],
//        'ps_jz'=>['field'=>'ps_jz','title'=>'科学、军事价值','brief'=>'科学军事价值','minVal'=>0,'maxVal'=>4,nopadding=>1],
//        'ps_cx'=>['field'=>'ps_cx','title'=>'创新性','brief'=>'创新性','minVal'=>0,'maxVal'=>1]
    ],
    "ALL_REMARK_FIELD"=>[
        'ps_cj',
        'ps_ql',
        'ps_jz',
        'ps_cx'
    ]
);