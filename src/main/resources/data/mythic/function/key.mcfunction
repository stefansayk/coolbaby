# called by the Fabric mod when a player presses the ability key (default X)
tag @s add mythic.caster
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"seelenernter"}] run function mythic:active/seelenernter/press
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"glutbart"}] run function mythic:active/glutbart/press
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"sternenspeer"}] run function mythic:active/sternenspeer/press
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"geisterbogen"}] run function mythic:active/geisterbogen/press
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"tiefseejaeger"}] run function mythic:active/tiefseejaeger/press
execute if items entity @s weapon.mainhand *[minecraft:custom_data~{mythic:"abyssdreizack"}] run function mythic:active/abyssdreizack/press
tag @s remove mythic.caster
