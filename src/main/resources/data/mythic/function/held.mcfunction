# passive aura while a legend is held in the main hand
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"seelenernter"}] run particle minecraft:soul ~ ~0.9 ~ 0.4 0.5 0.4 0.01 1
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"glutbart"}] run particle minecraft:small_flame ~ ~0.9 ~ 0.4 0.5 0.4 0.01 2
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"glutbart"}] run effect give @s minecraft:fire_resistance 3 0 true
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"sternenspeer"}] run particle minecraft:end_rod ~ ~1 ~ 0.5 0.6 0.5 0.01 1
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"geisterbogen"}] run particle minecraft:composter ~ ~1 ~ 0.5 0.6 0.5 0.01 2
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"tiefseejaeger"}] run particle minecraft:snowflake ~ ~1 ~ 0.4 0.5 0.4 0.01 1
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"abyssdreizack"}] run particle minecraft:nautilus ~ ~1 ~ 0.5 0.6 0.5 0.4 2
