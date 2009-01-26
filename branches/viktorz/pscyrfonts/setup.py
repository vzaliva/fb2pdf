#!/usr/bin/env python2.4

from distutils.core import setup
import os

setup(name='fb2pdf',
      version='1.0',
      description='FictionBook2 to PDF conversion tools',
      author='Vadim Zaliva, et. al.',
      author_email='lord@crocodile.org',
      url='http://code.google.com/p/fb2pdf/',
      packages=['fb2pdf'],
      package_dir={'fb2pdf': 'src/fb2pdf'},
      scripts=['scripts/fb2pdf_queue_send','scripts/fb2pdf_queue_clear','scripts/fb2pdf_queue_receive','scripts/fbdaemon','scripts/fb2tex'],
      data_files=[('share/texmf-local/', ['src/TeX/verse.sty', 'src/TeX/epigraph.sty','src/TeX/sectsty.dtx', 'src/TeX/sectsty.ins']),
                  ('share/fb2pdf',['etc/broken-image.png']), 
                  ('share/fb2pdf/pscyr-fonts',['src/TeX/pscyr-fonts/%s' % fname for fname in os.listdir('src/TeX/pscyr-fonts')])]
     )