# runs at the target point of Geisterregen
summon minecraft:arrow ~0 ~12 ~0 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~1.5 ~12 ~0 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~-1.5 ~12 ~0 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~0 ~12 ~1.5 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~0 ~12 ~-1.5 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~1.2 ~12 ~1.2 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~-1.2 ~12 ~1.2 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~1.2 ~12 ~-1.2 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~-1.2 ~12 ~-1.2 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~2.6 ~12 ~0.6 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~-2.6 ~12 ~-0.6 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~0.6 ~12 ~-2.6 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
summon minecraft:arrow ~-0.6 ~12 ~2.6 {Motion:[0.0d,-1.8d,0.0d],pickup:0b,damage:4.0d,Tags:["mythic.rain"]}
execute as @e[type=minecraft:arrow,tag=mythic.rain] run data modify entity @s Owner set from entity @p[tag=mythic.caster] UUID
tag @e[type=minecraft:arrow,tag=mythic.rain] remove mythic.rain
particle minecraft:sculk_soul ~ ~1 ~ 2 0.5 2 0.02 40
particle minecraft:composter ~ ~12 ~ 2.5 0.3 2.5 0 60
playsound minecraft:entity.vex.charge player @a ~ ~ ~ 2 0.7
playsound minecraft:entity.arrow.shoot player @a ~ ~ ~ 2 0.6
