# turn sealed (freshly crafted) legends into the real one, or refund duplicates
execute if items entity @s container.* *[minecraft:custom_data~{mythic_seal:"seelenernter"}] run function mythic:legend/seelenernter/found
execute if items entity @s weapon.offhand *[minecraft:custom_data~{mythic_seal:"seelenernter"}] run function mythic:legend/seelenernter/found
execute if items entity @s container.* *[minecraft:custom_data~{mythic_seal:"glutbart"}] run function mythic:legend/glutbart/found
execute if items entity @s weapon.offhand *[minecraft:custom_data~{mythic_seal:"glutbart"}] run function mythic:legend/glutbart/found
execute if items entity @s container.* *[minecraft:custom_data~{mythic_seal:"sternenspeer"}] run function mythic:legend/sternenspeer/found
execute if items entity @s weapon.offhand *[minecraft:custom_data~{mythic_seal:"sternenspeer"}] run function mythic:legend/sternenspeer/found
execute if items entity @s container.* *[minecraft:custom_data~{mythic_seal:"geisterbogen"}] run function mythic:legend/geisterbogen/found
execute if items entity @s weapon.offhand *[minecraft:custom_data~{mythic_seal:"geisterbogen"}] run function mythic:legend/geisterbogen/found
execute if items entity @s container.* *[minecraft:custom_data~{mythic_seal:"tiefseejaeger"}] run function mythic:legend/tiefseejaeger/found
execute if items entity @s weapon.offhand *[minecraft:custom_data~{mythic_seal:"tiefseejaeger"}] run function mythic:legend/tiefseejaeger/found
execute if items entity @s container.* *[minecraft:custom_data~{mythic_seal:"abyssdreizack"}] run function mythic:legend/abyssdreizack/found
execute if items entity @s weapon.offhand *[minecraft:custom_data~{mythic_seal:"abyssdreizack"}] run function mythic:legend/abyssdreizack/found
# recipe book: show a recipe only while its legend is still free
execute if score #seelenernter mythic.forged matches 1.. run recipe take @s mythic:seelenernter
execute unless score #seelenernter mythic.forged matches 1.. run recipe give @s mythic:seelenernter
execute if score #glutbart mythic.forged matches 1.. run recipe take @s mythic:glutbart
execute unless score #glutbart mythic.forged matches 1.. run recipe give @s mythic:glutbart
execute if score #sternenspeer mythic.forged matches 1.. run recipe take @s mythic:sternenspeer
execute unless score #sternenspeer mythic.forged matches 1.. run recipe give @s mythic:sternenspeer
execute if score #geisterbogen mythic.forged matches 1.. run recipe take @s mythic:geisterbogen
execute unless score #geisterbogen mythic.forged matches 1.. run recipe give @s mythic:geisterbogen
execute if score #tiefseejaeger mythic.forged matches 1.. run recipe take @s mythic:tiefseejaeger
execute unless score #tiefseejaeger mythic.forged matches 1.. run recipe give @s mythic:tiefseejaeger
execute if score #abyssdreizack mythic.forged matches 1.. run recipe take @s mythic:abyssdreizack
execute unless score #abyssdreizack mythic.forged matches 1.. run recipe give @s mythic:abyssdreizack
