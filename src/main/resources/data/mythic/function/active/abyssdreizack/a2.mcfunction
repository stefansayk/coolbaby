# Sog des Abgrunds: Zieht Gegner im Umkreis von 8 Blöcken zu dir und hüllt sie in Dunkelheit.
tag @e[type=!#mythic:not_target,tag=!mythic.caster,distance=..8] add mythic.t
execute as @e[tag=mythic.t,distance=4..] at @s facing entity @p[tag=mythic.caster] feet positioned ^ ^ ^3 if block ~ ~ ~ #mythic:passable if block ~ ~1 ~ #mythic:passable run tp @s ~ ~ ~
effect give @e[tag=mythic.t] minecraft:darkness 4 0
effect give @e[tag=mythic.t] minecraft:slowness 2 1
particle minecraft:squid_ink ~ ~1 ~ 3 0.6 3 0.05 120
particle minecraft:nautilus ~ ~1 ~ 4 1 4 1 80
playsound minecraft:entity.elder_guardian.curse player @a ~ ~ ~ 0.8 0.8
playsound minecraft:entity.warden.sonic_charge player @a ~ ~ ~ 0.8 1.4
tag @e[tag=mythic.t] remove mythic.t
