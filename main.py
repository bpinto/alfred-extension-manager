#!/usr/bin/env python
# -*- coding: utf-8 -*-
#
# jmjeong, 2013/3/25

import alfred
import subprocess
import re
import os
import plistlib
from uuid import uuid4

import sys
reload(sys)
sys.setdefaultencoding('utf-8')

def process():
    dirname = os.path.dirname(os.path.abspath('.'))

    dirs = [f for f in os.listdir(dirname) if os.path.isdir(os.path.join(dirname, f))]

    results = []

    for (idx,d) in enumerate(dirs):
        try:
            print os.path.join(dirname, d, 'settings.plist')
            plist = plistlib.readPlist(os.path.join(dirname, d, 'info.plist'))
        except:
            continue

        title = plist['name']
        disabled = plist.get('disabled', None)
        createdby = plist['createdby']
        displayTitle = title + (' - disabled' if disabled else '')

        results.append({'title': displayTitle, 'createdby' : createdby, 'disabled' : disabled, 'directory' : d})

    results = sorted(results, key=lambda a: a['title'].lower())

    resultsData = [alfred.Item(title=f['title'], subtitle=' by ' + (f['createdby'] or "[noinfo]"), attributes = {'uid':uuid4(), 'arg':os.path.join(dirname,f['directory'])}, icon=os.path.join(dirname, f['directory'], u"icon.png")) for f in results]

    alfred.write(alfred.xml(resultsData, maxresults=None))


if __name__ == '__main__':
    process()
