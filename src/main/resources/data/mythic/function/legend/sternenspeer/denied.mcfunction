# the legend already exists: break the seal, give the materials back
loot give @s loot mythic:refund/sternenspeer
tellraw @s ["",{"text":"✦ ","color":"dark_red"},{"text": "Sternenspeer", "color": "#c89aff", "bold": true},{"text":" existiert bereits in dieser Welt. Das Siegel zerbricht, du bekommst deine Materialien zurück.","color":"gray"}]
execute at @s run playsound minecraft:block.glass.break master @s ~ ~ ~ 1 0.6
