# HealthFog
An ensemble deep learning based smart healthcare system for automatic diagnosis of heart diseases in integrated IoT and Fog computing environments
<div align="center">
<img src="https://github.com/Cloudslab/HealthFog/blob/master/HeartModel/fog-arch.jpg" width="700" align="middle">
</div>

## Quick installation
HealthFog uses a master-slave design as shown in the figure above. To setup HealthFog in your fog environment follow these steps:
<b>Note:</b> You need atleast two windows/linux systems with python 3. Follow the following steps in each fog node (master and worker):
1. Install xampp in windows or use <i>Install-scripts/fogbus-install-generic.sh script</i> in linux device.
2. Clone HealthFog repo at <i>C:/xampp/htdocs/</i> (in windows) or <i>var/www/html/</i> (in linux).
3. Change directory to the HealthFog repo folder.
4. Run ```python3 -m pip install -r requirements.txt```.
5. Run ```run.sh```.

Follow these steps in master node:
1. Update config.txt with IP addresses of all worker nodes (each in a new line) after the first line of 'Enable Master Disable Aneka'. 
2. If connected to cloud using VPN, add cloud IP addresses in cloud.txt (each in a new line).

Now download the <i>Android/FastHeartTest.apk</i> in an android device and enter master IP address to begin healthcare analysis!

## Developer

[Shreshth Tuli](https://www.github.com/shreshthtuli)

## Cite this work
```
@article{tuli2020healthfog,
  title={{HealthFog: An ensemble deep learning based Smart Healthcare System for Automatic Diagnosis of Heart Diseases in integrated IoT and fog computing environments}},
  author={Tuli, Shreshth and Basumatary, Nipam and Gill, Sukhpal Singh and Kahani, Mohsen and Arya, Rajesh Chand and Wander, Gurpreet Singh and Buyya, Rajkumar},
  journal={Future Generation Computer Systems},
  volume={104},
  pages={187--200},
  year={2020},
  publisher={Elsevier}
}
```

## References
* Shreshth Tuli, Redowan Mahmud, Shikhar Tuli, and Rajkumar Buyya, [FogBus: A Blockchain-based Lightweight Framework for Edge and Fog Computing.](http://buyya.com/papers/FogBus-JSS.pdf) Journal of Systems and Software (JSS), Volume 154, Pages: 22-36, ISSN: 0164-1212, Elsevier Press, Amsterdam, The Netherlands, August 2019.
* **Shreshth Tuli, Nipam Basumatary, Sukhpal Singh Gill, Mohsen Kahani, Rajesh Chand Arya, Gurpreet Singh Wander, and Rajkumar Buyya, [HealthFog: An Ensemble Deep Learning based Smart Healthcare System for Automatic Diagnosis of Heart Diseases in Integrated IoT and Fog Computing Environments](http://buyya.com/papers/HealthFog.pdf), Future Generation Computer Systems (FGCS), Volume 104, Pages: 187-200, ISSN: 0167-739X, Elsevier Press, Amsterdam, The Netherlands, March 2020.**
* Shreshth Tuli, Nipam Basumatary, and Rajkumar Buyya, [EdgeLens: Deep Learning based Object Detection in Integrated IoT, Fog and Cloud Computing Environments](http://buyya.com/papers/EdgeLensAnekaCloud2019.pdf), Proceedings of the 4th IEEE International Conference on Information Systems and Computer Networks (ISCON 2019, IEEE Press, USA), Mathura, India, November 21-22, 2019.

[![](http://www.cloudbus.org/logo/cloudbuslogo-v5a.png)](http://cloudbus.org/)
